<?php

namespace App\Http\Controllers\Beranda;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HargaKomoditasController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $komoditasList = DB::table('dinas_perindustrian_perdagangan')
            ->select('jenis_bahan_pokok')
            ->distinct()
            ->pluck('jenis_bahan_pokok');

        $data = [];

        foreach ($komoditasList as $komoditas) {
            $avgToday = DB::table('dinas_perindustrian_perdagangan')
                ->whereDate('tanggal_dibuat', $today)
                ->where('jenis_bahan_pokok', $komoditas)
                ->avg('kg_harga');

            $avgYesterday = DB::table('dinas_perindustrian_perdagangan')
                ->whereDate('tanggal_dibuat', $yesterday)
                ->where('jenis_bahan_pokok', $komoditas)
                ->avg('kg_harga');

            $selisih = null;
            $status = 'tidak ada data';

            if (!is_null($avgToday) && !is_null($avgYesterday)) {
                $selisih = $avgToday - $avgYesterday;
                $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            }

            $data[] = [
                'komoditas' => $komoditas,
                'rata_rata_hari_ini' => round($avgToday, 2),
                'rata_rata_kemarin' => round($avgYesterday, 2),
                'selisih' => round($selisih, 2),
                'status' => $status
            ];
        }

        return response()->json($data);
    }

    public function komoditas_filter(Request $request)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $komoditas = $request->jenis_bahan_pokok;
        // $komoditas = 'a';

        $dataToday = DB::table('dinas_perindustrian_perdagangan')
            ->whereDate('tanggal_dibuat', $today)
            ->where('jenis_bahan_pokok', 'like', '%'.$komoditas.'%')
            ->get();

        $dataYesterday = DB::table('dinas_perindustrian_perdagangan')
            ->whereDate('tanggal_dibuat', $yesterday)
            ->where('jenis_bahan_pokok', 'like', '%'.$komoditas.'%')
            ->get();

        $markets = DB::table('dinas_perindustrian_perdagangan')
            ->select('pasar', 'jenis_bahan_pokok')
            ->where('jenis_bahan_pokok', 'like', '%'.$komoditas.'%')
            ->distinct()
            ->get();

        // dd($dataToday);

        $result = [];

        foreach ($markets as $market) {
            $hargaToday = $dataToday->where('jenis_bahan_pokok', $market->jenis_bahan_pokok)->where('pasar', $market->pasar)->pluck('kg_harga');
            $hargaYesterday = $dataYesterday->where('jenis_bahan_pokok', $market->jenis_bahan_pokok)->where('pasar', $market->pasar)->pluck('kg_harga');

            $avgToday = $hargaToday->avg();
            $avgYesterday = $hargaYesterday->avg();

            $selisih = null;
            $status = 'Tidak ada data';

            if (!is_null($avgToday) && !is_null($avgYesterday)) {
                $selisih = $avgToday - $avgYesterday;
                $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            }

            $result[] = [
                'komoditas' => $market->jenis_bahan_pokok,
                'rata_rata_hari_ini' => round($avgToday, 2),
                'rata_rata_kemarin' => round($avgYesterday, 2),
                'selisih' => round($selisih, 2),
                'status' => $status,
                'pasar' => $market->pasar,
            ];
        }

        return response()->json(['data' => $result], 200);
    }

    public function pasar_filter(Request $request)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $pasar = $request->pasar;
        // $pasar = 'Pasar Tanjung';
        // return response()->json($pasar);

        $dataToday = DB::table('dinas_perindustrian_perdagangan')
            ->whereDate('tanggal_dibuat', $today)
            ->where('pasar', 'like', '%'.$pasar.'%')
            ->get();

        $dataYesterday = DB::table('dinas_perindustrian_perdagangan')
            ->whereDate('tanggal_dibuat', $yesterday)
            ->where('pasar', 'like', '%'.$pasar.'%')
            ->get();

        $comodities = DB::table('dinas_perindustrian_perdagangan')
            ->select('pasar', 'jenis_bahan_pokok')
            ->where('pasar', 'like', '%'.$pasar.'%')
            ->distinct()
            ->get();

        // dd($comodities);

        $result = [];

        foreach ($comodities as $comodities) {
            $hargaToday = $dataToday->where('jenis_bahan_pokok', $comodities->jenis_bahan_pokok)->where('pasar', $comodities->pasar)->pluck('kg_harga');
            $hargaYesterday = $dataYesterday->where('jenis_bahan_pokok', $comodities->jenis_bahan_pokok)->where('pasar', $comodities->pasar)->pluck('kg_harga');

            $avgToday = $hargaToday->avg();
            $avgYesterday = $hargaYesterday->avg();

            $selisih = null;
            $status = 'Tidak ada data';

            if (!is_null($avgToday) && !is_null($avgYesterday)) {
                $selisih = $avgToday - $avgYesterday;
                $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            }

            $result[] = [
                'komoditas' => $comodities->jenis_bahan_pokok,
                'rata_rata_hari_ini' => round($avgToday, 2),
                'rata_rata_kemarin' => round($avgYesterday, 2),
                'selisih' => round($selisih, 2),
                'status' => $status,
                'pasar' => $comodities->pasar,
                
            ];
        }

        return response()->json(['data' => $result, 'inputPasar' => $pasar], 200);
    }

    // KOMEN IKI OJOK DIHAPUS!
    // public function komoditas_filter(Request $request)
    // {
    //     $today = Carbon::today();
    //     $yesterday = Carbon::yesterday();

    //     $dataByMarket = DB::table('dinas_perindustrian_perdagangan')
    //         ->select('pasar', 'jenis_bahan_pokok')
    //         ->get()
    //         ->groupBy('pasar');
            
    //     // return response()->json(['data' => $komoditasList]);

    //     $data = [];

    //     foreach ($dataByMarket as $data) {
    //         foreach ($data as $komoditas) {
    //             $avgToday = DB::table('dinas_perindustrian_perdagangan')
    //                 ->whereDate('tanggal_dibuat', $today)
    //                 ->where('jenis_bahan_pokok', $komoditas->jenis_bahan_pokok)
    //                 ->avg('kg_harga');
    
    //             $avgYesterday = DB::table('dinas_perindustrian_perdagangan')
    //                 ->whereDate('tanggal_dibuat', $yesterday)
    //                 ->where('jenis_bahan_pokok', $komoditas->jenis_bahan_pokok)
    //                 ->avg('kg_harga');
    
    //             $selisih = null;
    //             $status = 'Tidak ada data';
    
    //             if (!is_null($avgToday) && !is_null($avgYesterday)) {
    //                 $selisih = $avgToday - $avgYesterday;
    //                 $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
    //             }
    
    //             $data[] = [
    //                 'komoditas' => $komoditas->jenis_bahan_pokok,
    //                 'rata_rata_hari_ini' => round($avgToday, 2),
    //                 'rata_rata_kemarin' => round($avgYesterday, 2),
    //                 'selisih' => round($selisih, 2),
    //                 'status' => $status,
    //                 'pasar' => $komoditas->pasar,
    //             ];
    //         }
    //     }

    //     return response()->json(['data'=> $data], 200);
    // }
}
