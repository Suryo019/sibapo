<?php

namespace App\Http\Controllers\Beranda;

use Carbon\Carbon;
use App\Models\DPP;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pasar;

class HargaKomoditasController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $komoditasList = JenisBahanPokok::whereIn('id', function ($query) {
            $query->select('jenis_bahan_pokok_id')
                  ->from('dinas_perindustrian_perdagangan');
        })
        ->select('id', 'nama_bahan_pokok', 'gambar_bahan_pokok')
        ->distinct()
        ->get();

        // dd($komoditasList);

        $data = [];

        foreach ($komoditasList as $komoditas) {
            $avgToday = DB::table('dinas_perindustrian_perdagangan')
                ->whereDate('tanggal_dibuat', $today)
                ->where('jenis_bahan_pokok_id', $komoditas->id)
                ->avg('kg_harga');
        
            $avgYesterday = DB::table('dinas_perindustrian_perdagangan')
                ->whereDate('tanggal_dibuat', $yesterday)
                ->where('jenis_bahan_pokok_id', $komoditas->id)
                ->avg('kg_harga');
        
            $selisih = null;
            $status = 'Tidak ada data';
        
            if (!is_null($avgToday) && !is_null($avgYesterday)) {
                $selisih = $avgToday - $avgYesterday;
                $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            }
        
            $data[] = [
                'komoditas' => $komoditas->nama_bahan_pokok,
                'gambar_komoditas' => $komoditas->gambar_bahan_pokok,
                'rata_rata_hari_ini' => round($avgToday, 2),
                'rata_rata_kemarin' => round($avgYesterday, 2),
                'selisih' => round($selisih, 2),
                'status' => $status,
            ];
        }

        return response()->json(['message' => 'Data berhasil dimuat', 'data' => $data]);
    }

    public function chart(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m', $request->periode);
        $month = $date->month;
        $year = $date->year;

        $periodFY = $this->konversi_nama_bulan_id($request->periode) . ' ' . $year;

        $dpp = DPP::join('pasar', 'dinas_perindustrian_perdagangan.pasar_id', '=', 'pasar.id')
            ->join('jenis_bahan_pokok', 'dinas_perindustrian_perdagangan.jenis_bahan_pokok_id', '=', 'jenis_bahan_pokok.id')
            ->whereMonth('tanggal_dibuat', $month)
            ->whereYear('tanggal_dibuat', $year)
            ->where('pasar.nama_pasar', $request->pasar)
            // ->where('jenis_bahan_pokok.nama_bahan_pokok', $request->bahan_pokok)
            ->selectRaw("
                jenis_bahan_pokok.nama_bahan_pokok as jenis_bahan_pokok,
                dinas_perindustrian_perdagangan.kg_harga,
                dinas_perindustrian_perdagangan.tanggal_dibuat,
                pasar.nama_pasar as pasar,
                DAY(tanggal_dibuat) as hari
            ")
            ->get()
            ->groupBy('jenis_bahan_pokok');
            
        // dd($dpp);

        return response()->json([
            'data' => $dpp,
            'periode' => $periodFY,
        ]);
    }

    public function komoditas_filter(Request $request)
    {
        // $today = Carbon::today();
        // $yesterday = Carbon::yesterday();
        $komoditas = $request->jenis_bahan_pokok;

        $data = DB::table('dinas_perindustrian_perdagangan as dpp')
            ->join('jenis_bahan_pokok as jbp', 'dpp.jenis_bahan_pokok_id', '=', 'jbp.id')
            ->join('pasar as p', 'dpp.pasar_id', '=', 'p.id')
            ->where('jbp.nama_bahan_pokok', 'like', '%' . $komoditas . '%')
            ->select('jbp.nama_bahan_pokok', 'jbp.gambar_bahan_pokok', 'p.nama_pasar', 'dpp.kg_harga', 'dpp.tanggal_dibuat')
            ->orderByDesc('dpp.tanggal_dibuat')
            ->get();

        $grouped = $data->groupBy(fn ($item) => $item->nama_bahan_pokok . '|' . $item->nama_pasar);

        $result = [];

        foreach ($grouped as $key => $items) {
            $twoLatest = $items->take(2)->values();

            $latest = $twoLatest[0] ?? null;
            $second = $twoLatest[1] ?? null;

            $avgToday = $latest?->kg_harga;
            $avgYesterday = $second?->kg_harga;

            $selisih = null;
            $status = 'Tidak ada data';

            if (!is_null($avgToday) && !is_null($avgYesterday)) {
                $selisih = $avgToday - $avgYesterday;
                $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            }

            $result[] = [
                'komoditas' => $latest?->nama_bahan_pokok ?? $second?->nama_bahan_pokok,
                'gambar_komoditas' => $latest?->gambar_bahan_pokok ?? $second?->gambar_bahan_pokok,
                'rata_rata_hari_ini' => round($avgToday ?? 0, 2),
                'rata_rata_kemarin' => round($avgYesterday ?? 0, 2),
                'selisih' => round($selisih ?? 0, 2),
                'status' => $status,
                'pasar' => $latest?->nama_pasar ?? $second?->nama_pasar,
            ];
        }

        return response()->json(['data' => $result], 200);

    }


    public function pasar_filter(Request $request)
    {
        $pasar = $request->pasar;
        $data = DB::table('dinas_perindustrian_perdagangan as dpp')
            ->join('pasar as p', 'dpp.pasar_id', '=', 'p.id')
            ->join('jenis_bahan_pokok as jbp', 'dpp.jenis_bahan_pokok_id', '=', 'jbp.id')
            ->where('p.nama_pasar', 'like', '%' . $pasar . '%')
            ->select('jbp.nama_bahan_pokok', 'jbp.gambar_bahan_pokok', 'p.nama_pasar', 'dpp.kg_harga', 'dpp.tanggal_dibuat')
            ->orderByDesc('dpp.tanggal_dibuat')
            ->get();

        $grouped = $data->groupBy(fn ($item) => $item->nama_bahan_pokok . '|' . $item->nama_pasar);

        $result = [];

        foreach ($grouped as $key => $items) {
            $twoLatest = $items->take(2)->values();

            $latest = $twoLatest[0] ?? null;
            $second = $twoLatest[1] ?? null;

            $avgToday = $latest?->kg_harga;
            $avgYesterday = $second?->kg_harga;

            $selisih = null;
            $status = 'Tidak ada data';

            if (!is_null($avgToday) && !is_null($avgYesterday)) {
                $selisih = $avgToday - $avgYesterday;
                $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            }

            $result[] = [
                'komoditas' => $latest?->nama_bahan_pokok ?? $second?->nama_bahan_pokok,
                'gambar_komoditas' => $latest?->gambar_bahan_pokok ?? $second?->gambar_bahan_pokok,
                'rata_rata_hari_ini' => round($avgToday ?? 0, 2),
                'rata_rata_kemarin' => round($avgYesterday ?? 0, 2),
                'selisih' => round($selisih ?? 0, 2),
                'status' => $status,
                'pasar' => $latest?->nama_pasar ?? $second?->nama_pasar,
            ];
        }

        return response()->json(['data' => $result, 'inputPasar' => $pasar], 200);

    }



    // Controller halaman statistik
    public function render_sorting_child_items(Request $request)
    {
        $data = $request->data;

        // dd($data);

        if ($data == 'pasar') {
            $items = Pasar::select('nama_pasar')
                ->distinct()
                ->get();
        } elseif ($data == 'jenis_bahan_pokok') {
            $items =JenisBahanPokok::select('nama_bahan_pokok')
                ->distinct()
                ->get();
        } else {
            return response()->json(['error' => 'Parameter data tidak valid'], 400);
        }

        return response()->json(['data' => $items]);
    }


    public function statistik_pasar_filter(Request $request)
    {
        $carbonDate = Carbon::createFromFormat('Y-m', $request->periode);
        $jumlahHari = $carbonDate->daysInMonth;

        $dpp = DPP::select(
                    'jenis_bahan_pokok.nama_bahan_pokok as jenis_bahan_pokok',
                    'dinas_perindustrian_perdagangan.kg_harga',
                    'dinas_perindustrian_perdagangan.tanggal_dibuat',
                    'pasar.nama_pasar as pasar'
                )
                ->join('pasar', 'dinas_perindustrian_perdagangan.pasar_id', '=', 'pasar.id')
                ->join('jenis_bahan_pokok', 'dinas_perindustrian_perdagangan.jenis_bahan_pokok_id', '=', 'jenis_bahan_pokok.id')
                ->where('pasar.nama_pasar', $request->data)
                ->whereRaw("DATE_FORMAT(dinas_perindustrian_perdagangan.tanggal_dibuat, '%Y-%m') = ?", [$request->periode])
                ->get()
                ->groupBy('jenis_bahan_pokok')
                // dd($dpp);
                ->map(function($items) {
                    $row = [
                        'pasar' => $items[0]->pasar,
                        'jenis_bahan_pokok' => $items[0]->jenis_bahan_pokok,
                        'harga_per_tanggal' => [],
                    ];

                    foreach ($items as $item) {
                        $tanggal = (int) date('d', strtotime($item->tanggal_dibuat));
                        $row['harga_per_tanggal'][$tanggal] = $item->kg_harga;
                    }

                    return $row;
                });

        return response()->json([
            'data' => $dpp,
            'jumlahHari' => $jumlahHari
        ]);
    }


    public function statistik_jenis_bahan_pokok_filter(Request $request)
    {
        $carbonDate = Carbon::createFromFormat('Y-m', $request->periode);
        $jumlahHari = $carbonDate->daysInMonth;

        $dpp = DPP::select(
                    'jenis_bahan_pokok.nama_bahan_pokok as jenis_bahan_pokok',
                    'dinas_perindustrian_perdagangan.kg_harga',
                    'dinas_perindustrian_perdagangan.tanggal_dibuat',
                    'pasar.nama_pasar as pasar'
                )
                ->join('pasar', 'dinas_perindustrian_perdagangan.pasar_id', '=', 'pasar.id')
                ->join('jenis_bahan_pokok', 'dinas_perindustrian_perdagangan.jenis_bahan_pokok_id', '=', 'jenis_bahan_pokok.id')
                ->where('jenis_bahan_pokok.nama_bahan_pokok', $request->data)
                ->whereRaw("DATE_FORMAT(dinas_perindustrian_perdagangan.tanggal_dibuat, '%Y-%m') = ?", [$request->periode])
                ->get()
                ->groupBy('pasar')
                ->map(function($items) {
                    $row = [
                        'pasar' => $items[0]->pasar,
                        'jenis_bahan_pokok' => $items[0]->jenis_bahan_pokok,
                        'harga_per_tanggal' => [],
                    ];

                    foreach ($items as $item) {
                        $tanggal = (int) date('d', strtotime($item->tanggal_dibuat));
                        $row['harga_per_tanggal'][$tanggal] = $item->kg_harga;
                    }

                    return $row;
                });

        return response()->json([
            'data' => $dpp,
            'jumlahHari' => $jumlahHari
        ]);
    }


    // KOMEN IKI OJOK DIHAPUS!
    // public function komoditas_filter(Request $request)
    // {
    //     $today = Carbon::today();
    //     $yesterday = Carbon::yesterday();

    //     $dataByMarket = DB::table('dinas_perindustrian_perdagangan')
    //         ->select('pasar', 'jenis_bahan_pokok')
    //         ->get()
    //         ->groupBy('pasar');
            
    //     // return response()->json(['data' => $komoditasList]);

    //     $data = [];

    //     foreach ($dataByMarket as $data) {
    //         foreach ($data as $komoditas) {
    //             $avgToday = DB::table('dinas_perindustrian_perdagangan')
    //                 ->whereDate('tanggal_dibuat', $today)
    //                 ->where('jenis_bahan_pokok', $komoditas->jenis_bahan_pokok)
    //                 ->avg('kg_harga');
    
    //             $avgYesterday = DB::table('dinas_perindustrian_perdagangan')
    //                 ->whereDate('tanggal_dibuat', $yesterday)
    //                 ->where('jenis_bahan_pokok', $komoditas->jenis_bahan_pokok)
    //                 ->avg('kg_harga');
    
    //             $selisih = null;
    //             $status = 'Tidak ada data';
    
    //             if (!is_null($avgToday) && !is_null($avgYesterday)) {
    //                 $selisih = $avgToday - $avgYesterday;
    //                 $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
    //             }
    
    //             $data[] = [
    //                 'komoditas' => $komoditas->jenis_bahan_pokok,
    //                 'rata_rata_hari_ini' => round($avgToday, 2),
    //                 'rata_rata_kemarin' => round($avgYesterday, 2),
    //                 'selisih' => round($selisih, 2),
    //                 'status' => $status,
    //                 'pasar' => $komoditas->pasar,
    //             ];
    //         }
    //     }

    //     return response()->json(['data'=> $data], 200);
    // }
}
