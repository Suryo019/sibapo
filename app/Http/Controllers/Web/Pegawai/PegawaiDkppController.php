<?php

namespace App\Http\Controllers\Web\Pegawai;

use Carbon\Carbon;
use App\Models\DKPP;
use App\Models\User;
use App\Models\Pasar;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\JenisKomoditasDkpp;
use Illuminate\Pagination\LengthAwarePaginator;

class PegawaiDkppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodeUnikNama = DKPP::select(DB::raw('DISTINCT DATE_FORMAT(created_at, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $data = DKPP::all();
        return view('pegawai.dkpp.pegawai-dkpp', [
            'title' => 'Data Ketersediaan dan Kebutuhan Pangan Pokok',
            // 'data' => $data,
            'periods' => $periodeUnikNama,
        ]);
    }

    public function dashboard()
    {
        Carbon::setLocale('id');

        $today = now();
        $lastWeek = now()->copy()->subWeek();

        $mingguSekarang = $today->weekOfMonth;
        $bulanSekarang = $today->month;
        $tahunSekarang = $today->year;

        $mingguLalu = $lastWeek->weekOfMonth;
        $bulanLalu = $lastWeek->month;
        $tahunLalu = $lastWeek->year;

        $komoditasList = JenisKomoditasDkpp::pluck('nama_komoditas');

        // dd($komoditasList);

        $dataSelisih = [];

        foreach ($komoditasList as $komoditas) {
            $dataMingguSekarang = DB::table('dinas_ketahanan_pangan_peternakan')
                ->join('jenis_komoditas_dkpp', 'jenis_komoditas_dkpp.id', '=', 'dinas_ketahanan_pangan_peternakan.jenis_komoditas_dkpp_id')
                ->where('minggu', $mingguSekarang)
                ->whereMonth('dinas_ketahanan_pangan_peternakan.created_at', $bulanSekarang)
                ->whereYear('dinas_ketahanan_pangan_peternakan.created_at', $tahunSekarang)
                ->where('jenis_komoditas_dkpp.nama_komoditas', $komoditas)
                ->get();
            $avgMingguSekarang = $dataMingguSekarang->avg('ton_neraca_mingguan');

            $dataMingguLalu = DB::table('dinas_ketahanan_pangan_peternakan')
                ->join('jenis_komoditas_dkpp', 'jenis_komoditas_dkpp.id', '=', 'dinas_ketahanan_pangan_peternakan.jenis_komoditas_dkpp_id')
                ->where('minggu', $mingguLalu)
                ->whereMonth('dinas_ketahanan_pangan_peternakan.created_at', $bulanLalu)
                ->whereYear('dinas_ketahanan_pangan_peternakan.created_at', $tahunLalu)
                ->where('jenis_komoditas_dkpp.nama_komoditas', $komoditas)
                ->get();
            $avgMingguLalu = $dataMingguLalu->avg('ton_neraca_mingguan');
        
            $selisih = $avgMingguSekarang - $avgMingguLalu;
            $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            
            $dataSelisih[] = [
                'komoditas' => $komoditas,
                'keterangan_minggu_sekarang' => $dataMingguSekarang[0]->keterangan ?? 'Tidak ada data',
                'keterangan_minggu_lalu' => $dataMingguLalu[0]->keterangan ?? 'Tidak ada data',
                'status' => $status,
            ];
        }

        $dkpp = Riwayat::select('id', 'user_id', 'aksi', 'komoditas', 'created_at', 'updated_at')
                ->with(['user:id,name,role_id', 'user.role:id,role'])
                ->whereHas('user.role', function ($query) {
                    $query->where('role', 'dkpp');
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
            ->concat($dkpp)
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


        return view('pegawai.dkpp.pegawai-dkpp-dashboard', [
            'title' => 'Dashboard',
            'dataSelisih' => $dataSelisih,
            'aktivitas' => $paginator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $komoditas = JenisKomoditasDkpp::all();
        return view('pegawai.dkpp.pegawai-create-dkpp', [
            'title' => 'TAMBAH DATA',
            'commodities' => $komoditas,
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
    public function show(DKPP $dKPP)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DKPP $dkpp)
    {
        $jenis_komoditas = JenisKomoditasDkpp::all();
        return view('pegawai.dkpp.pegawai-update-dkpp', [
            'title' => 'UBAH DATA',
            'data' => $dkpp,
            'commodities' => $jenis_komoditas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DKPP $dKPP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DKPP $dKPP)
    {
        //
    }

    public function detail()
    {
        $currentWeek = now()->weekOfMonth;
        return view('pegawai.dkpp.pegawai-dkpp-detail', [
            'title' => 'Data Ketersediaan dan Kebutuhan Pangan Pokok',
            'currentWeek' => $currentWeek,
        ]);
    }
}
