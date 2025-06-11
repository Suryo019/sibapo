<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\Riwayat;
use App\Models\JenisIkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class DPController extends Controller
{
    public function index(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m', $request->periode);
        $year = $date->year;
        $periodFY = $this->konversi_nama_bulan_id($request->periode) . ' ' . $year;

        $cacheKey = "dp_index_{$request->periode}";

        $dp = DP::join('jenis_ikan', 'dinas_perikanan.jenis_ikan_id', '=', 'jenis_ikan.id')
                ->whereRaw("DATE_FORMAT(dinas_perikanan.tanggal_input, '%Y-%m') = ?", [$request->periode])
                ->selectRaw("
                    jenis_ikan.nama_ikan as jenis_ikan,
                    dinas_perikanan.ton_produksi,
                    dinas_perikanan.tanggal_input,
                    DAY(tanggal_input) as hari
                ")
                ->get()
                ->groupBy('jenis_ikan');

        return response()->json([
            'data' => $dp,
            'periode' => $periodFY,
        ]);
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

    public function listItem(Request $request, $jenisIkan)
    {
        try {
            $cacheKey = "dp_listitem_{$jenisIkan}";

            $inputPeriode = $request->input('periode');

            if ($inputPeriode){
                $filterPeriode = Carbon::createFromFormat('Y-m', $inputPeriode)
                    ->translatedFormat('Y');
            } else {
                $filterPeriode = now()->year;
            }

            $data = DP::join('jenis_ikan', 'dinas_perikanan.jenis_ikan_id', '=', 'jenis_ikan.id')
                    ->where('jenis_ikan.nama_ikan', $jenisIkan)
                    ->whereRaw("DATE_FORMAT(dinas_perikanan.tanggal_input, '%Y') = ?", [$filterPeriode])
                    ->select(
                        'dinas_perikanan.id as dp_id',
                        'dinas_perikanan.*',
                        'jenis_ikan.nama_ikan',
                    )
                    ->get()
                    ->map(function ($item) {
                        $carbon = Carbon::parse($item->tanggal_dibuat);
                        $bulanEn = $carbon->format('Y-m');
                        $bulanId = $this->konversi_nama_bulan_id($bulanEn);
                        $item->tanggal_dibuat = $carbon->format('d') . ' ' . $bulanId . ' ' . $carbon->format('Y');
                        return $item;
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
                'jenis_ikan_id' => 'required|exists:jenis_ikan,id',
                'ton_produksi' => 'required|numeric'
            ]);
            
            $validated['tanggal_input'] = now();
            $validated['user_id'] = Auth::user()->id;
            
            $dp = DP::create($validated);
            $nama_ikan = JenisIkan::find($dp->jenis_ikan_id)->nama_ikan;
            $data_stored = JenisIkan::select('nama_ikan')->where('id', $dp->jenis_ikan_id)->first();
            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' => $data_stored->nama_ikan,
                'aksi' => 'buat',
            ];
            
            Riwayat::create($riwayatStore);

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dp,
                'nama_ikan' => $data_stored->nama_ikan
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
            
            $dp = DP::find($id);
            
            if (!$dp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            
            $validated = $request->validate([
                'tanggal_input' => 'required|date',
                'jenis_ikan_id' => 'required|string',
                'ton_produksi' => 'required|numeric'
            ]);

            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' => $validated['jenis_ikan_id'],
                'aksi' => 'ubah'
            ];
            
            Riwayat::create($riwayatStore);
            $dp->update($validated);
            
            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $dp
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
            $dp = DP::find($id);

            if (!$dp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $dp->delete();
            
            $data_stored = JenisIkan::select('nama_ikan')->where('id', $dp->jenis_ikan_id)->first();

            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' => $data_stored->nama_ikan,
                'aksi' => 'hapus'
            ];
            
            Riwayat::create($riwayatStore);

            $dp->delete();

            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $data_stored,]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}