<?php

namespace App\Http\Controllers\Web;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\User;
use App\Models\JenisIkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class PerikananController extends Controller
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

        return view('admin.perikanan.admin-perikanan', [
            'title' => 'Data Aktivitas Produksi Ikan',
            'data' => $dp,
            'periods' => $periodeUnikNama,
        ]);
    }

    // Create
    public function create()
    {
        $ikan = JenisIkan::all();
        return view('admin.perikanan.admin-create-perikanan', [
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

        return view('admin.perikanan.admin-update-perikanan', [
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
            return view('admin.perikanan.admin-perikanan-detail', [
                'title' => 'Dinas Perikanan',
                'data' => [],
                'fishes' => [],
                'periods' => [],
                'numberPeriods' => [],
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
        

        return view('admin.perikanan.admin-perikanan-detail', [
            'title' => 'Dinas Perikanan',
            'data' => $dpProduksiBulanan,
            'fishes' => $fishes,
            'numberPeriods' => $periodeUnikAngka,
        ]);
    }
}