<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Models\DTPHP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DtphpController extends Controller
{
    // View
    public function index()
    {
        $dtphp = DTPHP::all();
        return view('admin.dtphp.admin-dtphp', [
            'title' => 'Data Tanaman',
            'data' => $dtphp
        ]);
    }

    // Create
    public function create()
    {
        return view('admin.dtphp.admin-create-dtphp', [
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
        return view('admin.dtphp.admin-update-dtphp', [
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
        $periode = explode('-', $periodeUnikAngka[1]);
        $jumlahHari = Carbon::createFromDate($periode[0], $periode[1])->daysInMonth;

        $periode = $periodeUnikAngka[1];

        // dd($periode);
        $dtphpProduksiHari = DTPHP::whereRaw('DATE_FORMAT(tanggal_input, "%Y-%m") = ?', [$periode])
        ->get()
        ->groupBy('jenis_komoditas')
        ->map(function ($items) {
            // dd($items);
            $row = [
                'id' => $items[0]->id,
                'user_id' => $items[0]->user_id,
                'ton_volume_produksi' => $items[0]->ton_volume_produksi,
                'jenis_komoditas' => $items[0]->jenis_komoditas,
                'data_asli' => $items, // Optional, untuk keperluan detail/debug
            ];
    
            foreach ($items as $item) {
                $tanggal = (int) date('d', strtotime($item->tanggal_input));
                $row['produksi_per_tanggal'][$tanggal] = $item->ton_volume_produksi;
            }
    
            return $row;
        })->values();
    
        $dtphpProduksiBulan = DTPHP::get()
            ->groupBy('jenis_komoditas')
            ->map(function ($items) {
                $row = [
                    'jenis_komoditas' => $items[0]->jenis_komoditas,
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

        return view('admin.dtphp.admin-dtphp-detail-produksi', [
            'title' => 'Dinas Tanaman Pangan dan Holtikultura',
            // 'data_produksi' => $dtphpProduksiHari,
            'data_produksi' => $dtphpProduksiBulan,
            'commodities' => DTPHP::select('jenis_komoditas')->distinct()->pluck('jenis_komoditas'),
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
        $periode = explode('-', $periodeUnikAngka[1]);
        $jumlahHari = Carbon::createFromDate($periode[0], $periode[1])->daysInMonth;

        $periode = $periodeUnikAngka[1];

        // dd($periode);
        $dtphpProduksiHari = DTPHP::whereRaw('DATE_FORMAT(tanggal_input, "%Y-%m") = ?', [$periode])
        ->get()
        ->groupBy('jenis_komoditas')
        ->map(function ($items) {
            // dd($items);
            $row = [
                'id' => $items[0]->id,
                'user_id' => $items[0]->user_id,
                'ton_volume_produksi' => $items[0]->ton_volume_produksi,
                'jenis_komoditas' => $items[0]->jenis_komoditas,
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
        ->groupBy('jenis_komoditas')
        ->map(function ($items) {
            // dd($items);
            $row = [
                'id' => $items[0]->id,
                'user_id' => $items[0]->user_id,
                'hektar_luas_panen' => $items[0]->hektar_luas_panen,
                'jenis_komoditas' => $items[0]->jenis_komoditas,
                'data_asli' => $items, // Optional, untuk keperluan detail/debug
            ];
    
            foreach ($items as $item) {
                $tanggal = (int) date('d', strtotime($item->tanggal_input));
                $row['panen_per_tanggal'][$tanggal] = $item->hektar_luas_panen;
            }
    
            return $row;
        })->values();
    
        $dtphpProduksiBulan = DTPHP::get()
            ->groupBy('jenis_komoditas')
            ->map(function ($items) {
                $row = [
                    'jenis_komoditas' => $items[0]->jenis_komoditas,
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
            ->groupBy('jenis_komoditas')
            ->map(function ($items) {
                $row = [
                    'jenis_komoditas' => $items[0]->jenis_komoditas,
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

        return view('admin.dtphp.admin-dtphp-detail-panen', [
            'title' => 'Dinas Tanaman Pangan dan Holtikultura',
            // 'data_panen' => $dtphpPanenHari,
            'data_panen' => $dtphpPanenBulan,
            'commodities' => DTPHP::select('jenis_komoditas')->distinct()->pluck('jenis_komoditas'),
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

        // $dp = DP::all();

        $dp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->distinct()
            ->pluck('jenis_komoditas');

        return view('admin.dtphp.admin-dtphp-panen', [
            'title' => 'Data Luas Panen',
            'data' => $dp,
            'commodities' => DTPHP::select('jenis_komoditas')->distinct()->pluck('jenis_komoditas'),
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

        // $dp = DP::all();

        $dp = DTPHP::whereMonth('tanggal_input', 4)
            ->whereYear('tanggal_input', 2025)
            ->distinct()
            ->pluck('jenis_komoditas');

        return view('admin.dtphp.admin-dtphp-produksi', [
            'title' => 'Volume Produksi Panen',
            'data' => $dp,
            'commodities' => DTPHP::select('jenis_komoditas')->distinct()->pluck('jenis_komoditas'),
            'periods' => $periodeUnikNama,
        ]);
    }
}
