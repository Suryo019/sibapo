<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\DTPHP;
use App\Models\Riwayat;
use App\Models\JenisTanaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;

class DTPHPController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        try {
            $cacheKey = 'dtphp_all_data';

            $data = Cache::remember($cacheKey, now()->addMinutes(60), function () {
                return DTPHP::all();
            });

            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function konversi_nama_bulan_id($date)
    {
        $mapBulan = [
            'January'   => 'Januari',
            'February'  => 'Februari',
            'March'     => 'Maret',
            'April'     => 'April',
            'May'       => 'Mei',
            'June'      => 'Juni',
            'July'      => 'Juli',
            'August'   => 'Agustus',
            'September' => 'September',
            'October'   => 'Oktober',
            'November'  => 'November',
            'December'  => 'Desember'
        ];

        $bulanEn = Carbon::createFromFormat('Y-m', $date)->format('F');
        $bulanId = $mapBulan[$bulanEn];

        return $bulanId;
    }

    public function listItem(Request $request, $jenisTanaman)
    {
        try {
            $cacheKey = "dtphp_listitem_{$jenisTanaman}";

            $data = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($jenisTanaman) {
                return DTPHP::join('jenis_tanaman', 'dinas_tanaman_pangan_holtikultural_perkebunan.jenis_tanaman_id', '=', 'jenis_tanaman.id')
                    ->where('jenis_tanaman.nama_tanaman', $jenisTanaman)
                    ->select(
                        'dinas_tanaman_pangan_holtikultural_perkebunan.id as dtphp_id',
                        'dinas_tanaman_pangan_holtikultural_perkebunan.*',
                        'jenis_tanaman.nama_tanaman',
                    )
                    ->get()
                    ->map(function($item) {
                        $carbon = Carbon::parse($item->tanggal_dibuat);
                        $bulanEn = $carbon->format('Y-m');
                        $bulanId = $this->konversi_nama_bulan_id($bulanEn);
                        $item->tanggal_dibuat = $carbon->format('d') . ' ' . $bulanId . ' ' . $carbon->format('Y');
                        return $item;
                    });
            });

            return response()->json(['data' => $data]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    // Menyimpan data baru
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'jenis_tanaman_id' => 'required|string',
                // 'tanggal_input' => 'required|date',
                'ton_volume_produksi' => 'required|numeric',
                'hektar_luas_panen' => 'required|numeric'
            ]);
    
            $validated['tanggal_input'] = now();
            $validated['user_id'] = Auth::user()->id;

            $dtphp = DTPHP::create($validated);

            $data_stored = JenisTanaman::select('nama_tanaman')->where('id', $dtphp->jenis_tanaman_id)->first();
            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' => $data_stored->nama_tanaman,
                'aksi' => 'buat'
            ];
            
            Riwayat::create($riwayatStore);
            
    
            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $data_stored
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    

    // Mengupdate data
    public function update(Request $request, $id)
    {
        try{
            $dtphp = DTPHP::find($id);

            if (!$dtphp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
    
            $validated = $request->validate([
                'jenis_tanaman_id' => 'sometimes|string',
                'tanggal_input' => 'sometimes|date',
                'ton_volume_produksi' => 'sometimes|numeric',
                'hektar_luas_panen' => 'sometimes|numeric'
            ]);

            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' => $validated['jenis_tanaman_id'],
                'aksi' => 'ubah'
            ];
            
            Riwayat::create($riwayatStore);
            $dtphp->update($validated);
    
            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $dtphp
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $th->getMessage()
            ], 500);
        }
    }    

    // Menghapus data
    public function destroy($id)
    {
        try {
            $dtphp = DTPHP::find($id);

            if (!$dtphp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' => $dtphp->jenis_tanaman_id,
                'aksi' => 'hapus'
            ];
            
            Riwayat::create($riwayatStore);
            $dtphp->delete();

            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $dtphp]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function panen(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m', $request->periode);
        $year = $date->year;

        // dd($year);

        $periodFY = $this->konversi_nama_bulan_id($request->periode) . ' ' . $year;

        $dp = DTPHP::join('jenis_tanaman', 'dinas_tanaman_pangan_holtikultural_perkebunan.jenis_tanaman_id', '=', 'jenis_tanaman.id')
            ->whereRaw("DATE_FORMAT(dinas_tanaman_pangan_holtikultural_perkebunan.tanggal_input, '%Y-%m') = ?", [$request->periode])
            ->selectRaw("
                jenis_tanaman.nama_tanaman as jenis_tanaman,
                dinas_tanaman_pangan_holtikultural_perkebunan.hektar_luas_panen,
                dinas_tanaman_pangan_holtikultural_perkebunan.tanggal_input,
                DAY(tanggal_input) as hari
            ")
            ->get()
            ->groupBy('jenis_tanaman');
            
        return response()->json([
            'data' => $dp,
            'periode' => $periodFY,
        ]);
    }    

    public function produksi(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m', $request->periode);
        $year = $date->year;

        // dd($year);

        $periodFY = $this->konversi_nama_bulan_id($request->periode) . ' ' . $year;

        $dp = DTPHP::join('jenis_tanaman', 'dinas_tanaman_pangan_holtikultural_perkebunan.jenis_tanaman_id', '=', 'jenis_tanaman.id')
            ->whereRaw("DATE_FORMAT(dinas_tanaman_pangan_holtikultural_perkebunan.tanggal_input, '%Y-%m') = ?", [$request->periode])
            ->selectRaw("
                jenis_tanaman.nama_tanaman as jenis_tanaman,
                dinas_tanaman_pangan_holtikultural_perkebunan.ton_volume_produksi,
                dinas_tanaman_pangan_holtikultural_perkebunan.tanggal_input,
                DAY(tanggal_input) as hari
            ")
            ->get()
            ->groupBy('jenis_tanaman');
            
        return response()->json([
            'data' => $dp,
            'periode' => $periodFY,
        ]);
    }      
}
