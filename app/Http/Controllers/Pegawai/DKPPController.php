<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\DKPP;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\JenisKomoditasDkpp;
use Illuminate\Validation\ValidationException;

class DKPPController extends Controller
{
    public function index(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m', $request->periode);
            $year = $date->year;

            $periodFY = $this->konversi_nama_bulan_id($request->periode) . ' ' . $year;

            $data = DKPP::join('jenis_komoditas_dkpp', 'jenis_komoditas_dkpp.id', '=', 'dinas_ketahanan_pangan_peternakan.jenis_komoditas_dkpp_id')
                ->whereRaw("DATE_FORMAT(dinas_ketahanan_pangan_peternakan.created_at, '%Y-%m') = ?", [$request->periode])
                // ->where('minggu', $week)
                ->select(
                    'dinas_ketahanan_pangan_peternakan.id as dkpp_id',
                    'dinas_ketahanan_pangan_peternakan.ton_ketersediaan',
                    'dinas_ketahanan_pangan_peternakan.ton_kebutuhan_perminggu',
                    'dinas_ketahanan_pangan_peternakan.minggu as minggu',
                    'jenis_komoditas_dkpp.nama_komoditas as nama_komoditas',
                )
                ->get()
                ->groupBy('minggu');

            return response()->json(['data' => $data, 'periode' => $periodFY]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function detail(Request $request)
    {
        $currentWeek = $request->minggu;
        $date = Carbon::createFromFormat('Y-m', $request->periode);
        $year = $date->year;
        $periodFY = $this->konversi_nama_bulan_id($request->periode) . ' ' . $year;

        $data = DKPP::join('jenis_komoditas_dkpp', 'jenis_komoditas_dkpp.id', '=', 'dinas_ketahanan_pangan_peternakan.jenis_komoditas_dkpp_id')
        ->whereRaw("DATE_FORMAT(dinas_ketahanan_pangan_peternakan.created_at, '%Y-%m') = ?", [$request->periode])
        ->where('dinas_ketahanan_pangan_peternakan.minggu', $currentWeek)
        ->orderBy('jenis_komoditas_dkpp.nama_komoditas', $request->sort)
        ->select(
            'dinas_ketahanan_pangan_peternakan.id as dkpp_id',
            'dinas_ketahanan_pangan_peternakan.ton_ketersediaan',
            'dinas_ketahanan_pangan_peternakan.ton_kebutuhan_perminggu',
            'dinas_ketahanan_pangan_peternakan.ton_neraca_mingguan',
            'dinas_ketahanan_pangan_peternakan.keterangan',
            'jenis_komoditas_dkpp.nama_komoditas as nama_komoditas',
        )
        ->get();

        return response()->json(['data' => $data, 'periode' => $periodFY]);
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

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'jenis_komoditas_dkpp_id' => 'required|string',
                'ton_ketersediaan' => 'required|numeric',
                'ton_kebutuhan_perminggu' => 'required|numeric',
                'minggu' => 'required|numeric', 
            ]);

            $validated['user_id'] = 1;
            $validated['ton_neraca_mingguan'] = $validated['ton_ketersediaan'] - $validated['ton_kebutuhan_perminggu'];

            $validated['keterangan'] = $validated['ton_neraca_mingguan'] > 0 ? 'Surplus' : ($validated['ton_neraca_mingguan'] < 0 ? 'Defisit' : 'Seimbang');

            $riwayatStore = [
                'user_id' => 3,
                'komoditas' => $validated['jenis_komoditas_dkpp_id'],
                'aksi' => 'buat'
            ];
            
            Riwayat::create($riwayatStore);
            $dkpp = DKPP::create($validated);
            $nama_komoditas = JenisKomoditasDkpp::select('nama_komoditas')->where('id', $dkpp->jenis_komoditas_dkpp_id)->first();

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $nama_komoditas
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

    public function update(Request $request, $id)
    {
        try {
            $dkpp = DKPP::find($id);

            if (!$dkpp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $validated = $request->validate([
                'jenis_komoditas_dkpp_id' => 'required|string',
                'ton_ketersediaan' => 'required|numeric',
                'ton_kebutuhan_perminggu' => 'required|numeric',
                'minggu' => 'required|numeric',
            ]);

            $validated['user_id'] = 1;
            $validated['ton_neraca_mingguan'] = $validated['ton_ketersediaan'] - $validated['ton_kebutuhan_perminggu'];

            $validated['keterangan'] = $validated['ton_neraca_mingguan'] > 0 ? 'Surplus' : ($validated['ton_neraca_mingguan'] < 0 ? 'Defisit' : 'Seimbang');

            $riwayatStore = [
                'user_id' => 3,
                'komoditas' => $validated['jenis_komoditas_dkpp_id'],
                'aksi' => 'ubah'
            ];
            
            Riwayat::create($riwayatStore);
            $dkpp->update($validated);

            $nama_komoditas = JenisKomoditasDkpp::select('nama_komoditas')->where('id', $dkpp->jenis_komoditas_dkpp_id)->first();

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $nama_komoditas
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $dkpp = DKPP::find($id);
            // return response()->json($dkpp);

            if (!$dkpp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $riwayatStore = [
                'user_id' => 3,
                'komoditas' => $dkpp->jenis_komoditas_dkpp_id,
                'aksi' => 'hapus'
            ];
            
            Riwayat::create($riwayatStore);
            $dkpp->delete();

            $nama_komoditas = JenisKomoditasDkpp::select('nama_komoditas')->where('id', $dkpp->jenis_komoditas_dkpp_id)->first();

            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $nama_komoditas]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
