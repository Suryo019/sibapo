<?php

namespace App\Http\Controllers\Web\Tamu;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TamuController extends Controller
{
    public function beranda()
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
            $status = 'Tidak ada data';

            if (!is_null($avgToday) && !is_null($avgYesterday)) {
                $selisih = $avgToday - $avgYesterday;
                $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            }

            $data[] = [
                'komoditas' => $komoditas,
                'rata_rata_hari_ini' => round($avgToday, 2),
                'rata_rata_kemarin' => round($avgYesterday, 2),
                'selisih' => round($selisih, 2),
                'status' => $status,
            ];
        }

        return view('tamu.beranda', [
            'title' => 'Beranda',
            'data' => $data,
            'kemarin' => Carbon::yesterday()->format('d F Y'),
        ]);
    }

    public function komoditas_filter()
    {
        return view('tamu.tamu-komoditas-filter', [
            'title' => 'Bahan Pokok',
            'kemarin' => Carbon::yesterday()->format('d F Y'),
        ]);
    }

    public function pasar_filter()
    {
        return view('tamu.tamu-pasar-filter', [
            'title' => 'Pasar',
            'kemarin' => Carbon::yesterday()->format('d F Y'),
        ]);
    }

    public function statistik()
    {
        return view('tamu.tamu-statistik', [
            'title' => 'Statistik',
        ]);
    }

    public function metadata()
    {
        return view('tamu.tamu-metadata', [
            'title' => 'Metadata',
        ]);
    }

    public function tentang_kami()
    {
        return view('tamu.tamu-tentang-kami', [
            'title' => 'Tentang Kami',
        ]);
    }

    public function hubungi_kami()
    {
        return view('tamu.tamu-hubungi-kami', [
            'title' => 'Hubungi Kami',
        ]);
    }
}
