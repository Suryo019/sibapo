<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\DKPP;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use App\Models\JenisKomoditasDkpp;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class DKPPController extends Controller
{
    public function index(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m', $request->periode);
            $year = $date->year;
            $periodFY = $this->konversi_nama_bulan_id($request->periode) . ' ' . $year;

            $cacheKey = "dkpp_index_{$request->periode}";

            $data = DKPP::join('jenis_komoditas_dkpp', 'jenis_komoditas_dkpp.id', '=', 'dinas_ketahanan_pangan_peternakan.jenis_komoditas_dkpp_id')
                    ->whereRaw("DATE_FORMAT(dinas_ketahanan_pangan_peternakan.created_at, '%Y-%m') = ?", [$request->periode])
                    ->select(
                        'dinas_ketahanan_pangan_peternakan.id as dkpp_id',
                        'dinas_ketahanan_pangan_peternakan.ton_ketersediaan',
                        'dinas_ketahanan_pangan_peternakan.ton_kebutuhan_perminggu',
                        'dinas_ketahanan_pangan_peternakan.minggu as minggu',
                        'jenis_komoditas_dkpp.nama_komoditas as nama_komoditas'
                    )
                    ->get()
                    ->groupBy('minggu');
            return response()->json(['data' => $data, 'periode' => $periodFY]);

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

        $cacheKey = "dkpp_detail_{$request->periode}_minggu_{$currentWeek}_sort_{$request->sort}";

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
                    'jenis_komoditas_dkpp.nama_komoditas as nama_komoditas'
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

            $validated['user_id'] = Auth::user()->id;
            $validated['ton_neraca_mingguan'] = $validated['ton_ketersediaan'] - $validated['ton_kebutuhan_perminggu'];

            $validated['keterangan'] = $validated['ton_neraca_mingguan'] > 0 ? 'Surplus' : ($validated['ton_neraca_mingguan'] < 0 ? 'Defisit' : 'Seimbang');

            $dkpp = DKPP::create($validated);

            $nama_komoditas = JenisKomoditasDkpp::select('nama_komoditas')->where('id', $dkpp->jenis_komoditas_dkpp_id)->first();
            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' =>  $nama_komoditas->nama_komoditas,
                'aksi' => 'buat'
            ];
            
            Riwayat::create($riwayatStore);

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

            $validated['user_id'] = Auth::user()->id;
            $validated['ton_neraca_mingguan'] = $validated['ton_ketersediaan'] - $validated['ton_kebutuhan_perminggu'];

            $validated['keterangan'] = $validated['ton_neraca_mingguan'] > 0 ? 'Surplus' : ($validated['ton_neraca_mingguan'] < 0 ? 'Defisit' : 'Seimbang');

            $dkpp->update($validated);
            
            $nama_komoditas = JenisKomoditasDkpp::select('nama_komoditas')->where('id', $dkpp->jenis_komoditas_dkpp_id)->first();
            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' => $nama_komoditas->nama_komoditas,
                'aksi' => 'ubah'
            ];
            
            Riwayat::create($riwayatStore);

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
            $dkpp->delete();
            
            $nama_komoditas = JenisKomoditasDkpp::select('nama_komoditas')->where('id', $dkpp->jenis_komoditas_dkpp_id)->first();
            
            $riwayatStore = [
                'user_id' => Auth::user()->id,
                'komoditas' => $nama_komoditas->nama_komoditas,
                'aksi' => 'hapus'
            ];
            
            Riwayat::create($riwayatStore);
            
            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $nama_komoditas]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
