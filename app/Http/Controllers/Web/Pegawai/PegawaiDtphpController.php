<?php

namespace App\Http\Controllers\Web\Pegawai;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DTPHP;
use App\Models\Riwayat;
use App\Models\JenisTanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class PegawaiDtphpController extends Controller
{
    // View
    public function index()
    {
        $periodeUnikNama = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dtphp = DP::all();

        $dtphp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->distinct()
            ->pluck('jenis_tanaman_id');

        return view('pegawai.dtphp.pegawai-dtphp-produksi', [
            'title' => 'Volume Produksi Panen',
            'data' => $dtphp,
            'commodities' => DTPHP::select('jenis_tanaman_id')->distinct()->pluck('jenis_tanaman_id'),
            'periods' => $periodeUnikNama,
        ]);
    }

    // Dashboard
    public function dashboard()
    {
        // Indikator Jumlah
        $jml_komoditas = JenisTanaman::count();
        $jml_pegawai = User::join('roles', 'users.role_id', 'roles.id')
            ->where('roles.role', 'dtphp')
            ->count();
        $jml_produksi = DTPHP::sum('ton_volume_produksi');
        $jml_panen = DTPHP::sum('hektar_luas_panen');


        // Tabel Perubahan
        $now = Carbon::now();

        $bulanIni = DTPHP::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->selectRaw('jenis_tanaman_id, SUM(ton_volume_produksi) as total_volume')
            ->groupBy('jenis_tanaman_id')
            ->get();

        $bulanLalu = DTPHP::whereMonth('created_at', $now->subMonth()->month)
            ->whereYear('created_at', $now->year)
            ->selectRaw('jenis_tanaman_id, SUM(ton_volume_produksi) as total_volume')
            ->groupBy('jenis_tanaman_id')
            ->get()
            ->keyBy('jenis_tanaman_id'); 
    
        $dataTabel = [];
    
        foreach ($bulanIni as $index => $item) {
            $jenisKomoditas = $item->jenis_tanaman;
            $volumeIni = $item->total_volume;
            $volumeLalu = $bulanLalu[$jenisKomoditas]->total_volume ?? 0;
            $selisih = $volumeIni - $volumeLalu;
            $ikon = $selisih >= 0 ? 'twemoji:up-arrow' : 'twemoji:down-arrow';
    
            $dataTabel[] = [
                'no' => $index + 1,
                'jenisKomoditas' => $jenisKomoditas,
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

        $dtphp = Riwayat::select('id', 'user_id', 'aksi', 'komoditas', 'created_at', 'updated_at')
                ->with(['user:id,name,role_id', 'user.role:id,role'])
                ->whereHas('user.role', function ($query) {
                    $query->where('role', 'dtphp');
                })
                ->get()
                ->map(function ($item) {
                    $item->dinas = strtoupper($item->user->role->role ?? '-');
                    $item->nama_user = $item->user->name ?? '-';

                    $item->waktu_utama = $item->deleted_at ?? $item->updated_at ?? $item->created_at;
                    $item->waktu = now()->diffForHumans($item->waktu_utama);

                    $item->aktivitas = match($item->aksi) {
                        'buat' => 'Menambah jenis tanaman ' . $item->komoditas,
                        'ubah' => 'Mengubah jenis tanaman ' . $item->komoditas,
                        default => 'Menghapus jenis tanaman ' . $item->komoditas,
                    };

                    return $item;
                });

        $aktivitas = collect()
            ->concat($dtphp)
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

        return view('pegawai.dtphp.pegawai-dtphp-dashboard', [
            'title' => 'Dashboard Dinas Tanaman Pangan Holtikultura',
            'jmlKomoditas' => $jml_komoditas,
            'jmlPegawai' => $jml_pegawai,
            'jmlProduksi' => $jml_produksi,
            'jmlPanen' => $jml_panen,
            'dataTabel' => $paginatorDataTabel,
            'aktivitas' => $paginator,
        ]);
    }

    public function dashboardPanen()
    {
        // Indikator Jumlah
        $jml_komoditas = DTPHP::select(DB::raw('LOWER(TRIM(jenis_tanaman_id)) AS jenis_normal'))
            ->distinct()
            ->get()
            ->count();
        $jml_pegawai = User::join('roles', 'users.role_id', 'roles.id')
            ->where('roles.role', 'dtphp')
            ->count();
        $jml_produksi = DTPHP::sum('ton_volume_produksi');
        $jml_panen = DTPHP::sum('hektar_luas_panen');


        // Tabel Perubahan
        $now = Carbon::now();

        $bulanIni = DTPHP::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->selectRaw('jenis_tanaman_id, SUM(hektar_luas_panen) as total_panen')
            ->groupBy('jenis_tanaman_id')
            ->get();

        $bulanLalu = DTPHP::whereMonth('created_at', $now->subMonth()->month)
            ->whereYear('created_at', $now->year)
            ->selectRaw('jenis_tanaman_id, SUM(hektar_luas_panen) as total_panen')
            ->groupBy('jenis_tanaman_id')
            ->get()
            ->keyBy('jenis_tanaman_id'); 
    
        $dataTabel = [];
    
        foreach ($bulanIni as $index => $item) {
            $jenisKomoditas = $item->jenis_tanaman;
            $panenIni = $item->total_panen;
            $panenLalu = $bulanLalu[$jenisKomoditas]->total_panen ?? 0;
            $selisih = $panenIni - $panenLalu;
            $ikon = $selisih >= 0 ? 'twemoji:up-arrow' : 'twemoji:down-arrow';
    
            $dataTabel[] = [
                'no' => $index + 1,
                'jenisKomoditas' => $jenisKomoditas,
                'icon' => $ikon,
                'panen' => $panenIni,
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

        $dtphp = Riwayat::select('id', 'user_id', 'aksi', 'komoditas', 'created_at', 'updated_at')
                ->with(['user:id,name,role_id', 'user.role:id,role'])
                ->whereHas('user.role', function ($query) {
                    $query->where('role', 'dtphp');
                })
                ->get()
                ->map(function ($item) {
                    $item->dinas = strtoupper($item->user->role->role ?? '-');
                    $item->nama_user = $item->user->name ?? '-';

                    $item->waktu_utama = $item->deleted_at ?? $item->updated_at ?? $item->created_at;
                    $item->waktu = now()->diffForHumans($item->waktu_utama);

                    $item->aktivitas = match($item->aksi) {
                        'buat' => 'Menambah jenis tanaman ' . $item->komoditas,
                        'ubah' => 'Mengubah jenis tanaman ' . $item->komoditas,
                        default => 'Menghapus jenis tanaman ' . $item->komoditas,
                    };

                    return $item;
                });

        $aktivitas = collect()
            ->concat($dtphp)
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

        return view('pegawai.dtphp.pegawai-dtphp-dashboard-panen', [
            'title' => 'Dashboard Dinas Tanaman Pangan Holtikultura',
            'jmlKomoditas' => $jml_komoditas,
            'jmlPegawai' => $jml_pegawai,
            'jmlProduksi' => $jml_produksi,
            'jmlPanen' => $jml_panen,
            'dataTabel' => $paginatorDataTabel,
            'aktivitas' => $paginator,
        ]);
    }

    // Create
    public function create()
    {
        return view('pegawai.dtphp.pegawai-create-dtphp', [
            'title' => 'Tambah Data'
        ]);
    }

    public function store(Request $request)
    {
        //
    }
    
    public function show(DTPHP $dTPHP)
    {
        //
    }    

    public function edit(DTPHP $dtphp)
    {
        return view('pegawai.dtphp.pegawai-update-dtphp', [
            'title' => 'Ubah Data',
            'data' => $dtphp,
        ]);
    }

    public function update(Request $request, DTPHP $dTPHP)
    {
        //
    }

    public function destroy(DTPHP $dTPHP)
    {
        //
    }

    public function detailProduksi()
    {
        Carbon::setLocale('id');

        $periodeUnikNama = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
                    ->get()
                    ->map(function ($item) {
                        $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
                        $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
                        return $item->periode_indonesia;
                    });
        $periodeUnikAngka = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
            ->get()
            ->map(function ($item) {
                return $item->periode;
            });

        // dd($periodeUnikAngka);
        $periode = explode('-', '2025-04');
        $jumlahHari = Carbon::createFromDate($periode[0], $periode[1])->daysInMonth;

        $periode = '2025-04';

        // dd($periode);
        $dtphpProduksiHari = DTPHP::whereRaw('DATE_FORMAT(tanggal_input, "%Y-%m") = ?', [$periode])
        ->get()
        ->groupBy('jenis_tanaman_id')
        ->map(function ($items) {
            // dd($items);
            $row = [
                'id' => $items[0]->id,
                'user_id' => $items[0]->user_id,
                'ton_volume_produksi' => $items[0]->ton_volume_produksi,
                'jenis_tanaman_id' => $items[0]->jenis_tanaman,
                'data_asli' => $items, // Optional, untuk keperluan detail/debug
            ];
    
            foreach ($items as $item) {
                $tanggal = (int) date('d', strtotime($item->tanggal_input));
                $row['produksi_per_tanggal'][$tanggal] = $item->ton_volume_produksi;
            }
    
            return $row;
        })->values();
    
        $dtphpProduksiBulan = DTPHP::get()
            ->groupBy('jenis_tanaman_id')
            ->map(function ($items) {
                $row = [
                    'jenis_tanaman_id' => $items[0]->jenis_tanaman,
                    'produksi_per_bulan' => [],
                ];
        
                foreach ($items as $item) {
                    $bulan = (int) date('m', strtotime($item->tanggal_input));
                    if (!isset($row['produksi_per_bulan'][$bulan])) {
                        $row['produksi_per_bulan'][$bulan] = 0;
                    }
                    $row['produksi_per_bulan'][$bulan] += $item->ton_volume_produksi;
                }
        
                return $row;
            })->values();  

        return view('pegawai.dtphp.pegawai-dtphp-detail-produksi', [
            'title' => 'Dinas Tanaman Pangan dan Holtikultura',
            // 'data_produksi' => $dtphpProduksiHari,
            'data_produksi' => $dtphpProduksiBulan,
            'commodities' => DTPHP::select('jenis_tanaman_id')->distinct()->pluck('jenis_tanaman_id'),
            'periods' => $periodeUnikNama,
            'numberPeriods' => $periodeUnikAngka,
            'daysInMonth' => $jumlahHari,
        ]);
    }

    public function detailPanen()
    {
        Carbon::setLocale('id');

        $periodeUnikNama = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
                    ->get()
                    ->map(function ($item) {
                        $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
                        $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
                        return $item->periode_indonesia;
                    });
        $periodeUnikAngka = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
            ->get()
            ->map(function ($item) {
                return $item->periode;
            });

        // dd($periodeUnikAngka);
        $periode = explode('-', '2025-04');
        $jumlahHari = Carbon::createFromDate($periode[0], $periode[1])->daysInMonth;

        $periode = '2025-04';

        // dd($periode);
        $dtphpProduksiHari = DTPHP::whereRaw('DATE_FORMAT(tanggal_input, "%Y-%m") = ?', [$periode])
        ->get()
        ->groupBy('jenis_tanaman_id')
        ->map(function ($items) {
            // dd($items);
            $row = [
                'id' => $items[0]->id,
                'user_id' => $items[0]->user_id,
                'ton_volume_produksi' => $items[0]->ton_volume_produksi,
                'jenis_tanaman_id' => $items[0]->jenis_tanaman,
                'data_asli' => $items, // Optional, untuk keperluan detail/debug
            ];
    
            foreach ($items as $item) {
                $tanggal = (int) date('d', strtotime($item->tanggal_input));
                $row['produksi_per_tanggal'][$tanggal] = $item->ton_volume_produksi;
            }
    
            return $row;
        })->values();

        $dtphpPanenHari = DTPHP::whereRaw('DATE_FORMAT(tanggal_input, "%Y-%m") = ?', [$periode])
        ->get()
        ->groupBy('jenis_tanaman_id')
        ->map(function ($items) {
            // dd($items);
            $row = [
                'id' => $items[0]->id,
                'user_id' => $items[0]->user_id,
                'hektar_luas_panen' => $items[0]->hektar_luas_panen,
                'jenis_tanaman_id' => $items[0]->jenis_tanaman,
                'data_asli' => $items, // Optional, untuk keperluan detail/debug
            ];
    
            foreach ($items as $item) {
                $tanggal = (int) date('d', strtotime($item->tanggal_input));
                $row['panen_per_tanggal'][$tanggal] = $item->hektar_luas_panen;
            }
    
            return $row;
        })->values();
    
        $dtphpProduksiBulan = DTPHP::get()
            ->groupBy('jenis_tanaman_id')
            ->map(function ($items) {
                $row = [
                    'jenis_tanaman_id' => $items[0]->jenis_tanaman,
                    'produksi_per_bulan' => [],
                ];
        
                foreach ($items as $item) {
                    $bulan = (int) date('m', strtotime($item->tanggal_input));
                    if (!isset($row['produksi_per_bulan'][$bulan])) {
                        $row['produksi_per_bulan'][$bulan] = 0;
                    }
                    $row['produksi_per_bulan'][$bulan] += $item->ton_volume_produksi;
                }
        
                return $row;
            })->values();  
    
        $dtphpPanenBulan = DTPHP::get()
            ->groupBy('jenis_tanaman_id')
            ->map(function ($items) {
                $row = [
                    'jenis_tanaman_id' => $items[0]->jenis_tanaman,
                    'panen_per_bulan' => [],
                ];
        
                foreach ($items as $item) {
                    $bulan = (int) date('m', strtotime($item->tanggal_input));
                    if (!isset($row['panen_per_bulan'][$bulan])) {
                        $row['panen_per_bulan'][$bulan] = 0;
                    }
                    $row['panen_per_bulan'][$bulan] += $item->hektar_luas_panen;
                }
        
                return $row;
            })->values();  

        return view('pegawai.dtphp.pegawai-dtphp-detail-panen', [
            'title' => 'Dinas Tanaman Pangan dan Holtikultura',
            // 'data_panen' => $dtphpPanenHari,
            'data_panen' => $dtphpPanenBulan,
            'commodities' => DTPHP::select('jenis_tanaman_id')->distinct()->pluck('jenis_tanaman_id'),
            'periods' => $periodeUnikNama,
            'numberPeriods' => $periodeUnikAngka,
            'daysInMonth' => $jumlahHari,
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

        // $dtphp = DP::all();

        $dtphp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->distinct()
            ->pluck('jenis_tanaman_id');

        return view('pegawai.dtphp.pegawai-dtphp-panen', [
            'title' => 'Data Luas Panen',
            'data' => $dtphp,
            'commodities' => DTPHP::select('jenis_tanaman_id')->distinct()->pluck('jenis_tanaman_id'),
            'periods' => $periodeUnikNama,
        ]);
    }

    public function produksi()
    {
        $periodeUnikNama = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dtphp = DP::all();

        $dtphp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->distinct()
            ->pluck('jenis_tanaman_id');

        return view('pegawai.dtphp.pegawai-dtphp-produksi', [
            'title' => 'Volume Produksi Panen',
            'data' => $dtphp,
            'commodities' => DTPHP::select('jenis_tanaman_id')->distinct()->pluck('jenis_tanaman_id'),
            'periods' => $periodeUnikNama,
        ]);
    }
}
