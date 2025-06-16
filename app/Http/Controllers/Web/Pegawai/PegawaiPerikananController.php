<?php

namespace App\Http\Controllers\Web\Pegawai;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Riwayat;
use App\Models\JenisIkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class PegawaiPerikananController extends Controller
{
    // View
    public function index()
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

        return view('pegawai.perikanan.pegawai-perikanan', [
            'title' => 'Data Aktivitas Produksi Ikan',
            'data' => $dp,
            'periods' => $periodeUnikNama,
        ]);
    }

    // Dashboard
    public function dashboard()
    {
        // Indikator Jumlah
        $jml_ikan = JenisIkan::count();
        $jml_pegawai = User::join('roles', 'users.role_id', 'roles.id')
            ->where('roles.role', 'perikanan')
            ->count();
        $jml_produksi = DP::sum('ton_produksi');


        // Tabel Perubahan
        $now = Carbon::now();

        $bulanIni = DP::with('jenis_ikan')
            ->whereMonth('tanggal_input', $now->month)
            ->whereYear('tanggal_input', $now->year)
            ->selectRaw('jenis_ikan_id, SUM(ton_produksi) as total_volume')
            ->groupBy('jenis_ikan_id')
            ->get();
        
        $bulanLalu = DP::with('jenis_ikan')
            ->whereMonth('tanggal_input', $now->subMonth()->month)
            ->whereYear('tanggal_input', $now->year)
            ->selectRaw('jenis_ikan_id, SUM(ton_produksi) as total_volume')
            ->groupBy('jenis_ikan_id')
            ->get()
            ->keyBy('jenis_ikan_id');    
    
        $dataTabel = [];
    
        foreach ($bulanIni as $index => $item) {
            $jenisIkanId = $item->jenis_ikan_id;
            $jenisIkan = $item->jenis_ikan->nama_ikan ?? '-';
            $volumeIni = $item->total_volume;
            $volumeLalu = $bulanLalu[$jenisIkanId]->total_volume ?? 0;            
            $selisih = $volumeIni - $volumeLalu;
            $ikon = $selisih >= 0 ? 'twemoji:up-arrow' : 'twemoji:down-arrow';
    
            $dataTabel[] = [
                'no' => $index + 1,
                'jenisIkan' =>  $jenisIkan,
                'icon' => $ikon,
                'volume' => $volumeIni,
                'perubahan' => $selisih,
            ];
        }        

        $collectionDataTabel = collect($dataTabel);

        $perPage = 5;
        $currentPageData = LengthAwarePaginator::resolveCurrentPage('page_data');
        $currentItemsData = $collectionDataTabel->slice(($currentPageData - 1) * $perPage, $perPage);
        
        $paginatorDataTabel = new LengthAwarePaginator(
            $currentItemsData,
            $collectionDataTabel->count(),
            $perPage,
            $currentPageData,
            ['path' => request()->url(), 'pageName' => 'page_data']
        );

        $dp = Riwayat::select('id', 'user_id', 'aksi', 'komoditas', 'created_at', 'updated_at')
                ->with(['user:id,name,role_id', 'user.role:id,role'])
                ->whereHas('user.role', function ($query) {
                    $query->where('role', 'perikanan');
                })
                ->get()
                ->map(function ($item) {
                    $item->dinas = strtoupper($item->user->role->role ?? '-');
                    $item->nama_user = $item->user->name ?? '-';

                    $item->waktu_utama = $item->deleted_at ?? $item->updated_at ?? $item->created_at;
                    $item->waktu = now()->diffForHumans($item->waktu_utama);

                    $item->aktivitas = match($item->aksi) {
                        'buat' => 'Menambah jenis ikan' . $item->komoditas,
                        'ubah' => 'Mengubah jenis ikan' . $item->komoditas,
                        default => 'Menghapus jenis ikan' . $item->komoditas,
                    };

                    return $item;
                });

        $aktivitas = collect()
            ->concat($dp)
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

        return view('pegawai.perikanan.pegawai-perikanan-dashboard', [
            'title' => 'Dashboard Dinas Perikanan',
            'jmlIkan' => $jml_ikan,
            'jmlPegawai' => $jml_pegawai,
            'jmlProduksi' => $jml_produksi,
            'dataTabel' => $paginatorDataTabel,
            'aktivitas' => $paginator,
        ]);
    }

    // Create
    public function create()
    {
        $ikan = JenisIkan::all();
        return view('pegawai.perikanan.pegawai-create-perikanan', [
            'title' => 'TAMBAH DATA',
            'fishes' => $ikan,
        ]);
    }

    public function store(Request $request)
    {
        //
    }
    
    public function show(DP $dP)
    {
        //
    }    

    public function edit(DP $perikanan)
    {
        $jenis_ikan = JenisIkan::all();

        return view('pegawai.perikanan.pegawai-update-perikanan', [
            'title' => 'UBAH DATA',
            'data' => $perikanan,
            'fishes' => $jenis_ikan,
        ]);
    }

    public function update(Request $request, DP $dP)
    {
        //
    }

    public function destroy(DP $dP)
    {
        //
    }
    
    public function detail(Request $request)
    {
        Carbon::setLocale('id');

        $inputPeriode = $request->input('periode');

        if ($inputPeriode){
            $filterPeriode = Carbon::createFromFormat('Y-m', $inputPeriode)
                ->translatedFormat('Y');
        } else {
            $filterPeriode = null;
        }

        $order = $request->input('order', 'asc');

        $periodeUnikAngka = DP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y") as periode'))
            ->orderBy('periode', 'desc')
            ->get()
            ->map(function ($item) {
                return $item->periode;
            });

        if ($periodeUnikAngka->isEmpty()) {
            return view('pegawai.perikanan.pegawai-perikanan-detail', [
                'title' => 'Dinas Perikanan',
                'data' => [],
                'fishes' => [],
                'periods' => [],
                'numberPeriods' => [],
                'daysInMonth' => 0,
            ]);
        }

        $periodeAktif = $filterPeriode ?? $periodeUnikAngka->first();

        $query = DP::query()->whereRaw('DATE_FORMAT(tanggal_input, "%Y") = ?', [$periodeAktif]);
    
        $data = $query->join('jenis_ikan', 'dinas_perikanan.jenis_ikan_id', '=', 'jenis_ikan.id')
            ->orderBy('jenis_ikan.nama_ikan', $order)
            ->get(); 

            $dpProduksiBulanan = $data->groupBy('jenis_ikan_id')
            ->map(function ($items) {
                $row = [
                    'id' => $items[0]->id,
                    'user_id' => $items[0]->user_id,
                    'jenis_ikan_id' => $items[0]->jenis_ikan_id,
                    'nama_ikan' => $items[0]->nama_ikan,
                    'produksi_per_bulan' => [],
                ];
    
                foreach ($items as $item) {
                    $bulan = (int) date('m', strtotime($item->tanggal_input));
                    if (!isset($row['produksi_per_bulan'][$bulan])) {
                        $row['produksi_per_bulan'][$bulan] = 0;
                    }
                    $row['produksi_per_bulan'][$bulan] += $item->ton_produksi;
                }
    
                return $row;
            })->values();

            $fishes = DB::table('dinas_perikanan')
            ->join('jenis_ikan', 'dinas_perikanan.jenis_ikan_id', '=', 'jenis_ikan.id')
            ->select('jenis_ikan.id', 'jenis_ikan.nama_ikan')
            ->distinct()
            ->get();
        

        return view('pegawai.perikanan.pegawai-perikanan-detail', [
            'title' => 'Dinas Perikanan',
            'data' => $dpProduksiBulanan,
            'fishes' => $fishes,
            'numberPeriods' => $periodeUnikAngka,
        ]);
    }
}
