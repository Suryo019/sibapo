<?php

namespace App\Http\Controllers\Web\Pimpinan;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\User;
use App\Models\DTPHP;
use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Web\AdminDashboardController;

class PimpinanController extends Controller
{
    public function index()
    {
        $jml_bahan_pokok = JenisBahanPokok::count();
        $jml_komoditas = DTPHP::select('jenis_komoditas')->distinct()->count();
        $jml_ikan = DP::select('jenis_ikan')->distinct()->count();
        $jml_pegawai = User::join('roles', 'users.role_id', 'roles.id')
            ->where('roles.role', '!=', 'admin')
            ->count();

        $adminDashboard = new AdminDashboardController();
        $aktivitas = $adminDashboard->aktivitas();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $aktivitas->slice(($currentPage - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator(
            $currentItems,
            $aktivitas->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pimpinan.pimpinan-dashboard', [
            'title' => 'Pimpinan Dashboard',
            'jmlBahanPokok' => $jml_bahan_pokok,
            'jmlKomoditas' => $jml_komoditas,
            'jmlIkan' => $jml_ikan,
            'jmlPegawai' => $jml_pegawai,
            'aktivitas' => $paginator,
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
        $periodeUnikNama = DKPP::select(DB::raw('DISTINCT DATE_FORMAT(created_at, "%Y-%m") as periode'))
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
