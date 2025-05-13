<?php

namespace App\Http\Controllers\Web\Pimpinan;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\DTPHP;
use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PimpinanController extends Controller
{
    public function index()
    {

        return view('pimpinan.pimpinan-dashboard', [
            'title' => 'Pimpinan Dashboard',
            // 'data' => $users
        ]);
    }

    public function disperindag()
    {
        $periodeUnikNama = DPP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_dibuat, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dpp = DPP::all();

        $dpp = JenisBahanPokok::select('nama_bahan_pokok')->get();
        $markets = Pasar::select('nama_pasar')->get();

        return view('pimpinan.pimpinan-disperindag', [
            'title' => 'Data Aktivitas Harga Pasar',
            'data' => $dpp,
            'markets' => $markets,
            'periods' => $periodeUnikNama,
        ]);
    }

    public function dkpp()
    {
        $periodeUnikNama = DKPP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $data = DKPP::all();
        return view('pimpinan.pimpinan-dkpp', [
            'title' => 'Data Ketersediaan dan Kebutuhan Pangan Pokok',
            // 'data' => $data,
            'periods' => $periodeUnikNama,
        ]);
    }

    public function panen()
    {
        $periodeUnikNama = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dp = DP::all();

        $dp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->distinct()
            ->pluck('jenis_komoditas');

        return view('pimpinan.pimpinan-dtphp-panen', [
            'title' => 'Data Luas Panen',
            'data' => $dp,
            'commodities' => DTPHP::select('jenis_komoditas')->distinct()->pluck('jenis_komoditas'),
            'periods' => $periodeUnikNama,
        ]);
    }

    public function volume()
    {
        $periodeUnikNama = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dp = DP::all();

        $dp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->distinct()
            ->pluck('jenis_komoditas');

        return view('pimpinan.pimpinan-dtphp-volume', [
            'title' => 'Volume Produksi Panen',
            'data' => $dp,
            'commodities' => DTPHP::select('jenis_komoditas')->distinct()->pluck('jenis_komoditas'),
            'periods' => $periodeUnikNama,
        ]);
    }

    public function perikanan()
    {
        $periodeUnikNama = DP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dp = DP::all();

        $dp = DP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->distinct()
            ->pluck('jenis_ikan');

        return view('pimpinan.pimpinan-perikanan', [
            'title' => 'Data Aktivitas Produksi Ikan',
            'data' => $dp,
            'fishes' => DP::select('jenis_ikan')->distinct()->pluck('jenis_ikan'),
            'periods' => $periodeUnikNama,
        ]);
    }
}
