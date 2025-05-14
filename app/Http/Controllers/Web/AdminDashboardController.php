<?php

namespace App\Http\Controllers\Web;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\User;
use App\Models\DTPHP;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $jml_bahan_pokok = JenisBahanPokok::count();
        $jml_komoditas = DTPHP::select('jenis_komoditas')->distinct()->count();
        $jml_ikan = DP::select('jenis_ikan')->distinct()->count();
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

        $dtphp = DTPHP::withTrashed()
            ->select('user_id', 'jenis_komoditas', 'aksi', 'created_at', 'updated_at', 'deleted_at')
            ->with('user:id,name')
            ->get()
            ->map(function ($item) {
                $item->dinas = 'DTPHP';
                $item->nama_user = $item->user->name ?? '-';

                $item->waktu_utama = $item->deleted_at ?? $item->updated_at ?? $item->created_at;
                $item->waktu = now()->diffForHumans($item->waktu_utama);

                $item->aktivitas = $item->aksi == 'buat' 
                    ? 'Menambah komoditas ' . $item->jenis_komoditas 
                    : ($item->aksi == 'ubah' 
                        ? 'Mengubah komoditas ' . $item->jenis_komoditas 
                        : 'Menghapus komoditas ' . $item->jenis_komoditas);
                return $item;
            });

        $dkpp = DKPP::withTrashed()
            ->select('user_id', 'jenis_komoditas', 'aksi', 'created_at', 'updated_at', 'deleted_at')
            ->with('user:id,name')
            ->get()
            ->map(function ($item) {
                $item->dinas = 'DKPP';
                $item->nama_user = $item->user->name ?? '-';

                $item->waktu_utama = $item->deleted_at ?? $item->updated_at ?? $item->created_at;
                $item->waktu = now()->diffForHumans($item->waktu_utama);
                
                $item->aktivitas = $item->aksi == 'buat' 
                    ? 'Menambah komoditas ' . $item->jenis_komoditas 
                    : ($item->aksi == 'ubah' 
                        ? 'Mengubah komoditas ' . $item->jenis_komoditas 
                        : 'Menghapus komoditas ' . $item->jenis_komoditas);
                return $item;
            });

        $perikanan = DP::withTrashed()
            ->select('user_id', 'jenis_ikan', 'aksi', 'created_at', 'updated_at', 'deleted_at')
            ->with('user:id,name')
            ->get()
            ->map(function ($item) {
                $item->dinas = 'Perikanan';
                $item->nama_user = $item->user->name ?? '-';

                $item->waktu_utama = $item->deleted_at ?? $item->updated_at ?? $item->created_at;
                $item->waktu = now()->diffForHumans($item->waktu_utama);

                $item->aktivitas = $item->aksi == 'buat' 
                    ? 'Menambah ikan ' . $item->jenis_ikan 
                    : ($item->aksi == 'ubah' 
                        ? 'Mengubah ikan ' . $item->jenis_ikan 
                        : 'Menghapus ikan ' . $item->jenis_ikan);
                return $item;
            });

        $disperindag = DPP::withTrashed()
            ->select('user_id', 'jenis_bahan_pokok_id', 'aksi', 'created_at', 'updated_at', 'deleted_at')
            ->with(['user:id,name', 'jenis_bahan_pokok:id,nama_bahan_pokok'])
            ->get()
            ->map(function ($item) {
                $item->dinas = 'Disperindag';
                $item->nama_user = $item->user->name ?? '-';

                $item->waktu_utama = $item->deleted_at ?? $item->updated_at ?? $item->created_at;
                $item->waktu = now()->diffForHumans($item->waktu_utama);

                $nama_bahan = $item->jenis_bahan_pokok->pluck('nama_bahan_pokok')->join(', ');
                $item->aktivitas = match($item->aksi) {
                    'buat' => 'Menambah bahan pokok ' . $nama_bahan,
                    'ubah' => 'Mengubah bahan pokok ' . $nama_bahan,
                    default => 'Menghapus bahan pokok ' . $nama_bahan,
                };
                return $item;
            });

        $aktivitas = collect()
            ->concat($dtphp)
            ->concat($dkpp)
            ->concat($perikanan)
            ->concat($disperindag)
            ->sortByDesc('waktu_utama')
            ->values();

        return $aktivitas;
    }
}
