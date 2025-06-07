<?php

namespace App\Http\Controllers\Web\Pimpinan;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\User;
use App\Models\DTPHP;
use App\Models\Pasar;
use App\Models\JenisIkan;
use App\Models\JenisTanaman;
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
        $jml_komoditas = JenisTanaman::count();
        $jml_ikan = JenisIkan::count();
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

        $dp = JenisTanaman::select('nama_tanaman')->get();

        return view('pimpinan.pimpinan-dtphp-panen', [
            'title' => 'Data Aktivitas Luas Panen Tanaman',
            'data' => $dp,
            'periods' => $periodeUnikNama,
        ]);
    }

    public function volume(Request $request)
    {
        $periodeUnikNama = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dp = DP::all();

        $dp = JenisTanaman::select('nama_tanaman')->get();

        return view('pimpinan.pimpinan-dtphp-volume', [
            'title' => 'Data Aktivitas Produksi Tanaman',
            'data' => $dp,
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

        $dp = JenisIkan::select('nama_ikan')->get();

        return view('pimpinan.pimpinan-perikanan', [
            'title' => 'Data Aktivitas Produksi Ikan',
            'data' => $dp,
            'periods' => $periodeUnikNama,
        ]);
    }
}
