<?php

namespace App\Http\Controllers\Web\Pegawai;

use Carbon\Carbon;
use App\Models\DPP;
use App\Models\User;
use App\Models\Pasar;
use App\Models\Riwayat;
use App\Models\BahanPokok;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class PegawaiDisperindagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        return view('pegawai.disperindag.pegawai-disperindag', [
            'title' => 'Data Aktivitas Harga Pasar',
            'data' => $dpp,
            'markets' => $markets,
            'periods' => $periodeUnikNama,
        ]);
    }

    public function dashboard()
    {
        Carbon::setLocale('id');
        
        $jml_bahan_pokok = JenisBahanPokok::count();
        $jml_pasar = Pasar::count();
        $jml_pegawai = User::join('roles', 'users.role_id', 'roles.id')
            ->where('roles.role', '=', 'disperindag')
            ->count();

        $disperindag = Riwayat::select('id', 'user_id', 'aksi', 'komoditas', 'created_at', 'updated_at')
                ->with(['user:id,name,role_id', 'user.role:id,role'])
                ->whereHas('user.role', function ($query) {
                    $query->where('role', 'disperindag');
                })
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
            ->concat($disperindag)
            ->sortByDesc('waktu_utama')
            ->values();
        
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


        return view('pegawai.disperindag.pegawai-disperindag-dashboard', [
            'title' => 'Dashboard',
            'jmlBahanPokok' => $jml_bahan_pokok,
            'jmlPasar' => $jml_pasar,
            'jmlPegawai' => $jml_pegawai,
            'aktivitas' => $paginator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasar = Pasar::all();
        $bahan_pokok = JenisBahanPokok::all();
        return view('pegawai.disperindag.pegawai-create-disperindag', [
            'title' => 'Tambah Data',
            'markets' => $pasar,
            'items' => $bahan_pokok,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // $dpp = DPP::all();
        // return view('pegawai.pegawai-disperindag', [
        //     'data' => $dpp
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dpp $data)
    {
        $pasar = Pasar::all();
        $bahan_pokok = JenisBahanPokok::all();
        return view('pegawai.disperindag.pegawai-update-disperindag', [
            'title' => 'Ubah Data',
            'data' => $data,
            'markets' => $pasar,
            'items' => $bahan_pokok,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dpp $dpp)
    {
        //
    }

    public function dppDetail()
    {
        $pasar = Pasar::select('nama_pasar')->distinct()->get();
        return view('pegawai.disperindag.pegawai-disperindag-detail', [
            'title' => 'Dinas Perindustrian dan Perdagangan',
            'markets' => $pasar,
        ]);
    }
}
