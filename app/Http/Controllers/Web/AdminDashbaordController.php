<?php

namespace App\Http\Controllers\Web;

use App\Models\DKPP;
use App\Models\User;
use App\Models\DTPHP;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use App\Http\Controllers\Controller;
use App\Models\DP;
use App\Models\DPP;

class AdminDashbaordController extends Controller
{
    public function dashboard()
    {
        $jml_bahan_pokok = JenisBahanPokok::count();
        $jml_komoditas = DTPHP::select('jenis_komoditas')->distinct()->count();
        $jml_pegawai = User::join('roles', 'users.role_id', 'roles.id')
            ->where('roles.role', '!=', 'admin')
            ->count();

        $tahunSekarang = date('Y');

        $total_dkpp_tahun_ini = DKPP::whereYear('tanggal_input', $tahunSekarang)->count();

        $persen_kategori_dkpp = DKPP::select('keterangan')
            ->whereYear('tanggal_input', $tahunSekarang)
            ->distinct()
            ->get()
            ->map(function($item) use ($tahunSekarang, $total_dkpp_tahun_ini) {
                $persentase_dkpp = [];

                $jml_komoditas_dkpp = DKPP::where('keterangan', $item->keterangan)
                    ->whereYear('tanggal_input', $tahunSekarang)
                    ->count();

                $persentase_per_komoditas = $total_dkpp_tahun_ini > 0 
                    ? ($jml_komoditas_dkpp / $total_dkpp_tahun_ini) * 100 
                    : 0;

                $persentase_dkpp[$item->keterangan] = $persentase_per_komoditas;

                return $persentase_dkpp;
            });

        $aktivitas = $this->aktivitas();

        return view('admin.admin-dashboard', [
            'title' => 'Dashboard Admin',
            'jmlBahanPokok' => $jml_bahan_pokok,
            'jmlKomoditas' => $jml_komoditas,
            'jmlPegawai' => $jml_pegawai,
            'persenKategoriDkpp' => $persen_kategori_dkpp,
            'aktivitas' => $aktivitas,
        ]);
    }

    public function aktivitas()
    {
        $dtphp = DTPHP::select('user_id', 'jenis_komoditas', 'aksi', 'created_at', 'updated_at', 'deleted_at')
            ->with('user:id,name')
            ->get()
            ->map(function ($item) {
                $item->dinas = 'DTPHP';
                $item->nama_user = $item->user->name ?? '-';

                $item->waktu = $item->deleted_at 
                    ? now()->diffForHumans($item->deleted_at)
                    : ($item->updated_at ? now()->diffForHumans($item->updated_at)
                    : now()->diffForHumans($item->created_at));

                $item->aktivitas = $item->aksi == 'buat' 
                    ? 'Menambah komoditas ' . $item->jenis_komoditas 
                    : ($item->aksi == 'ubah' 
                        ? 'Mengubah komoditas ' . $item->jenis_komoditas 
                        : 'Menghapus komoditas ' . $item->jenis_komoditas);
                return $item;
            });


        $dkpp = DKPP::select('user_id', 'jenis_komoditas', 'aksi', 'created_at', 'updated_at', 'deleted_at')
            ->with('user:id,name')
            ->get()
            ->map(function ($item) {
                $item->dinas = 'DKPP';
                $item->nama_user = $item->user->name ?? '-';

                $item->waktu = $item->deleted_at 
                    ? now()->diffForHumans($item->deleted_at)
                    : ($item->updated_at ? now()->diffForHumans($item->updated_at)
                    : now()->diffForHumans($item->created_at));
                
                $item->aktivitas = $item->aksi == 'buat' 
                    ? 'Menambah komoditas ' . $item->jenis_komoditas 
                    : ($item->aksi == 'ubah' 
                        ? 'Mengubah komoditas ' . $item->jenis_komoditas 
                        : 'Menghapus komoditas ' . $item->jenis_komoditas);
                return $item;
            });

        $perikanan = DP::select('user_id', 'jenis_ikan', 'aksi', 'created_at', 'updated_at', 'deleted_at')
            ->with('user:id,name')
            ->get()
            ->map(function ($item) {
                $item->dinas = 'Perikanan';
                $item->nama_user = $item->user->name ?? '-';

                $item->waktu = $item->deleted_at 
                    ? now()->diffForHumans($item->deleted_at)
                    : ($item->updated_at ? now()->diffForHumans($item->updated_at)
                    : now()->diffForHumans($item->created_at));

                $item->aktivitas = $item->aksi == 'buat' 
                    ? 'Menambah ikan ' . $item->jenis_ikan 
                    : ($item->aksi == 'ubah' 
                        ? 'Mengubah ikan ' . $item->jenis_ikan 
                        : 'Menghapus ikan ' . $item->jenis_ikan);
                return $item;
            });

        $disperindag = DPP::select('user_id', 'jenis_bahan_pokok_id', 'aksi', 'created_at', 'updated_at', 'deleted_at')
            ->with(['user:id,name', 'jenis_bahan_pokok:id,nama_bahan_pokok'])
            ->get()
            ->map(function ($item) {
                $item->dinas = 'Disperindag';
                $item->nama_user = $item->user->name ?? '-';

                $item->waktu = $item->deleted_at 
                    ? now()->diffForHumans($item->deleted_at)
                    : ($item->updated_at ? now()->diffForHumans($item->updated_at)
                    : now()->diffForHumans($item->created_at));

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
        ->sortByDesc('created_at')
        ->values();

        return $aktivitas;
    }

    // public function aktivitas()
    // {
    //     $dtphp = DTPHP::select('user_id', 'aksi', 'created_at', 'updated_at', 'deleted_at')->get();
    //     $dkpp = DKPP::select('user_id', 'aksi', 'created_at', 'updated_at', 'deleted_at')->get();
    //     $perikanan = DP::select('user_id', 'aksi', 'created_at', 'updated_at', 'deleted_at')->get();
    //     $disperindag = DPP::select('user_id', 'aksi', 'created_at', 'updated_at', 'deleted_at')->get();

    //     $aktivitas = collect()
    //     ->concat($dtphp)
    //     ->concat($dkpp)
    //     ->concat($perikanan)
    //     ->concat($disperindag)
    //     ->sortByDesc('created_at')
    //     ->values();


    //     // dd([
    //     //     'dtphp' => $dtphp->toArray(),
    //     //     'dkpp' => $dkpp->toArray(),
    //     //     'perikanan' => $perikanan->toArray(),
    //     //     'disperindag' => $disperindag->toArray(),
    //     // ]);

    //     return $aktivitas;
    // }

}
