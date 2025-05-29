<?php

namespace App\Http\Controllers\Web;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\User;
use App\Models\DTPHP;
use App\Models\Riwayat;
use App\Models\JenisIkan;
use App\Models\JenisTanaman;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $jml_bahan_pokok = JenisBahanPokok::count();
        $jml_komoditas = JenisTanaman::count();
        $jml_ikan = JenisIkan::count();
        $jml_pegawai = User::join('roles', 'users.role_id', 'roles.id')
            ->where('roles.role', '!=', 'admin')
            ->count();

        $aktivitas = $this->aktivitas();

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

        return view('admin.admin-dashboard', [
            'title' => 'Dashboard Admin',
            'jmlBahanPokok' => $jml_bahan_pokok,
            'jmlKomoditas' => $jml_komoditas,
            'jmlIkan' => $jml_ikan,
            'jmlPegawai' => $jml_pegawai,
            'aktivitas' => $paginator,
        ]);
    }

    public function persen_dkpp()
    {
        $currentWeek = now()->weekOfMonth;

        if ($currentWeek > 4) {
            $currentWeek = 4;
        }

        $total_dkpp_minggu_ini = DKPP::where('minggu', $currentWeek)->count();

        $persen_kategori_dkpp = DKPP::select('keterangan')
            ->where('minggu', $currentWeek)
            ->distinct()
            ->get()
            ->map(function($item) use ($currentWeek, $total_dkpp_minggu_ini) {
                $persentase_dkpp = [];

                $jml_komoditas_dkpp = DKPP::where('keterangan', $item->keterangan)
                    ->where('minggu', $currentWeek)
                    ->count();

                $persentase_per_komoditas = $total_dkpp_minggu_ini > 0 
                    ? ($jml_komoditas_dkpp / $total_dkpp_minggu_ini) * 100 
                    : 0;

                $persentase_dkpp[$item->keterangan] = $persentase_per_komoditas;

                return $persentase_dkpp;
            });
        
        return response()->json(['message' => 'Persentase berhasil dimuat', 'persenKategoriDkpp' => $persen_kategori_dkpp]);
    }

    public function grafik_dkpp()
    {
        $bulan_ini = now()->month;

        $data = DKPP::select('keterangan', 'minggu')
            ->whereMonth('created_at', $bulan_ini)
            ->get();

        $keterangan_list = $data->pluck('keterangan')->unique();
        $minggu_list = [1, 2, 3, 4];

        $neraca_dkpp = [];

        foreach ($minggu_list as $minggu) {
            $minggu_data = ['minggu' => $minggu];

            foreach ($keterangan_list as $keterangan) {
                $jumlah = $data
                    ->where('minggu', $minggu)
                    ->where('keterangan', $keterangan)
                    ->count();

                $minggu_data[$keterangan] = $jumlah;
            }

            $neraca_dkpp[] = $minggu_data;
        }

        return response()->json(['message' => 'Berhasil memuat data', 'data' => $neraca_dkpp]);
    }

    public function aktivitas()
    {
        Carbon::setLocale('id');

        // dd(Riwayat::with('user')->first());

        $riwayat = Riwayat::select('id', 'user_id', 'aksi', 'komoditas', 'created_at', 'updated_at')
                ->with(['user:id,name,role_id', 'user.role:id,role'])
                ->get()
                ->map(function ($item) {
                    $item->dinas = strtoupper($item->user->role->role ?? '-');
                    $item->nama_user = $item->user->name ?? '-';

                    $item->waktu_utama = $item->deleted_at ?? $item->updated_at ?? $item->created_at;
                    $item->waktu = now()->diffForHumans($item->waktu_utama);

                    $item->aktivitas = match($item->aksi) {
                        'buat' => 'Menambah komoditas ' . $item->komoditas,
                        'ubah' => 'Mengubah komoditas ' . $item->komoditas,
                        default => 'Menghapus komoditas ' . $item->komoditas,
                    };

                    return $item;
                });
        $aktivitas = collect()
            ->concat($riwayat)
            ->sortByDesc('waktu_utama')
            ->values();

        return $aktivitas;
    }
}
