<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\DTPHP;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DTPHPController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        try {
            $data = DTPHP::all();
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
            $data = DTPHP::join('jenis_tanaman', 'dinas_tanaman_pangan_holtikultural_perkebunan.jenis_tanaman_id', '=', 'jenis_tanaman.id')
                ->where('jenis_tanaman.nama_tanaman', $jenisTanaman)
                // ->whereRaw("DATE_FORMAT(dinas_tanaman_pangan_holtikultural_perkebunan.tanggal_dibuat, '%Y-%m') = ?", [$request->periode])
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
            $validated['user_id'] = 1;

            $riwayatStore = [
                'user_id' => 4,
                'komoditas' => $validated['jenis_tanaman_id'],
                'aksi' => 'buat'
            ];
            
            Riwayat::create($riwayatStore);
            
            $dtphp = DTPHP::create($validated);
    
            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dtphp
            ], 201);

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
                'user_id' => 4,
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
                'user_id' => 4,
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

    public function panen()
    {
        try {
            $dtphp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->where('jenis_tanaman_id', 'Suket Teki')
            ->select('jenis_tanaman_id', 'hektar_luas_panen')
            ->get();

            return response()->json([
                'data' => $dtphp
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }    

    public function produksi()
    {
        try {
            $dtphp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->where('jenis_tanaman_id', 'Suket Teki')
            ->select('jenis_tanaman_id', 'ton_volume_produksi')
            ->get();

            return response()->json([
                'data' => $dtphp
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }    
}
