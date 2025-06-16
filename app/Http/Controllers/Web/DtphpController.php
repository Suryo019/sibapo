<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DTPHP;
use App\Models\JenisTanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $tanaman = JenisTanaman::all();
        return view('admin.dtphp.admin-create-dtphp', [
            'title' => 'TAMBAH DATA',
            'commodities' => $tanaman,
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
        $jenis_tanaman = JenisTanaman::all();

        return view('admin.dtphp.admin-update-dtphp', [
            'title' => 'UBAH DATA',
            'data' => $dtphp,
            'commodities' => $jenis_tanaman,
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

    public function detailProduksi(Request $request)
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
        
        $periodeUnikAngka = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y") as periode'))
            ->orderBy('periode', 'desc')
            ->get()
            ->map(function ($item) {
                return $item->periode;
            });

        if ($periodeUnikAngka->isEmpty()) {
            return view('admin.dtphp.admin-dtphp-detail-produksi', [
                'title' => 'Dinas Tanaman Pangan Holtikultura Perkebunan',
                'data_produksi' => [],
                'commodities' => [],
                'periods' => [],
                'numberPeriods' => [],
            ]);
        }

        $periodeAktif = $filterPeriode ?? $periodeUnikAngka->first();

        $query = DTPHP::query()->whereRaw('DATE_FORMAT(tanggal_input, "%Y") = ?', [$periodeAktif]);
    
        $data = $query->join('jenis_tanaman', 'dinas_tanaman_pangan_holtikultural_perkebunan.jenis_tanaman_id', '=', 'jenis_tanaman.id')
            ->orderBy('jenis_tanaman.nama_tanaman', $order)
            ->get();

        $dtphpProduksiBulan = $data->groupBy('jenis_tanaman_id')
            ->map(function ($items) {
                $row = [
                    'id' => $items[0]->id,
                    'user_id' => $items[0]->user_id,
                    'jenis_tanaman_id' => $items[0]->jenis_tanaman,
                    'nama_tanaman' => $items[0]->nama_tanaman,
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

        $commodities = DB::table('dinas_tanaman_pangan_holtikultural_perkebunan')
            ->join('jenis_tanaman', 'dinas_tanaman_pangan_holtikultural_perkebunan.jenis_tanaman_id', '=', 'jenis_tanaman.id')
            ->select('jenis_tanaman.id', 'jenis_tanaman.nama_tanaman')
            ->distinct()
            ->get();

        return view('admin.dtphp.admin-dtphp-detail-produksi', [
            'title' => 'Dinas Tanaman Pangan Holtikultura Perkebunan',
            'data_produksi' => $dtphpProduksiBulan,
            'commodities' => $commodities,
            'numberPeriods' => $periodeUnikAngka,
        ]);
    }

    public function detailPanen(Request $request)
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

        $periodeUnikAngka = DTPHP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_input, "%Y") as periode'))
            ->orderBy('periode', 'desc')
            ->get()
            ->map(function ($item) {
                return $item->periode;
            });

        if ($periodeUnikAngka->isEmpty()) {
            return view('admin.dtphp.admin-dtphp-detail-panen', [
                'title' => 'Dinas Tanaman Pangan Holtikultura Perkebunan',
                'data_panen' => [],
                'commodities' => [],
                'periods' => [],
                'numberPeriods' => [],
            ]);
        }

        $periodeAktif = $filterPeriode ?? $periodeUnikAngka->first();

        $query = DTPHP::query()->whereRaw('DATE_FORMAT(tanggal_input, "%Y") = ?', [$periodeAktif]);

        $data = $query->join('jenis_tanaman', 'dinas_tanaman_pangan_holtikultural_perkebunan.jenis_tanaman_id', '=', 'jenis_tanaman.id')
            ->orderBy('jenis_tanaman.nama_tanaman', $order)
            ->get();

            $dtphpPanenBulan = $data->groupBy('jenis_tanaman_id')
            ->map(function ($items) {
                $row = [
                    'id' => $items[0]->id,
                    'user_id' => $items[0]->user_id,
                    'jenis_tanaman_id' => $items[0]->jenis_tanaman,
                    'nama_tanaman' => $items[0]->nama_tanaman,
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

            $commodities = DB::table('dinas_tanaman_pangan_holtikultural_perkebunan')
            ->join('jenis_tanaman', 'dinas_tanaman_pangan_holtikultural_perkebunan.jenis_tanaman_id', '=', 'jenis_tanaman.id')
            ->select('jenis_tanaman.id', 'jenis_tanaman.nama_tanaman')
            ->distinct()
            ->get();
        

        return view('admin.dtphp.admin-dtphp-detail-panen', [
            'title' => 'Dinas Tanaman Pangan Holtikultura Perkebunan',
            'data_panen' => $dtphpPanenBulan,
            'commodities' => $commodities,
            'numberPeriods' => $periodeUnikAngka,
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

        return view('admin.dtphp.admin-dtphp-panen', [
            'title' => 'Data Aktivitas Luas Panen Tanaman',
            'data' => $dp,
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

        $dp = JenisTanaman::select('nama_tanaman')->get();

        return view('admin.dtphp.admin-dtphp-produksi', [
            'title' => 'Data Aktivitas Produksi Tanaman',
            'data' => $dp,
            'periods' => $periodeUnikNama,
        ]);
    }
}
