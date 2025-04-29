<?php

namespace App\Http\Controllers\Web\Beranda;

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
                $status = $selisih > 0 ? 'naik' : ($selisih < 0 ? 'turun' : 'tetap');
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
}
