<?php

namespace App\Http\Controllers\Beranda;

use Carbon\Carbon;
use App\Models\DPP;
use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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

    public function komoditas_filter(Request $request)
    {
        $komoditas = $request->jenis_bahan_pokok;
        $cleaned = strtolower(trim($komoditas));
        $cacheKey = 'komoditas_filter_' . md5($komoditas);

        $result = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($cleaned) {
            // Log::info("Cache MISS: $cleaned");
            $data = DB::table('dinas_perindustrian_perdagangan as dpp')
                ->join('jenis_bahan_pokok as jbp', 'dpp.jenis_bahan_pokok_id', '=', 'jbp.id')
                ->join('pasar as p', 'dpp.pasar_id', '=', 'p.id')
                ->where('jbp.nama_bahan_pokok', 'like', '%' . $cleaned . '%')
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

            return $result;
        });

        return response()->json(['data' => $result], 200);
    }


    public function pasar_filter(Request $request)
    {
        $pasar = $request->pasar;
        $cacheKey = 'pasar_filter_' . md5($pasar);

        $result = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($pasar) {
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

            return $result;
        });

        return response()->json(['data' => $result, 'inputPasar' => $pasar], 200);
    }



    // Controller halaman statistik
    public function render_sorting_child_items(Request $request)
    {
        $data = $request->data;
        $cacheKey = "render_sorting_child_items_$data";

        $items = Cache::remember($cacheKey, 86400, function () use ($data) {
            if ($data == 'pasar') {
                return Pasar::select('nama_pasar')
                    ->distinct()
                    ->get();
            } elseif ($data == 'jenis_bahan_pokok') {
                return JenisBahanPokok::select('nama_bahan_pokok')
                    ->distinct()
                    ->get();
            } else {
                return null;
            }
        });

        if (is_null($items)) {
            return response()->json(['error' => 'Parameter data tidak valid'], 400);
        }

        return response()->json(['data' => $items]);
    }

    public function statistik_pasar_filter(Request $request)
    {
        $cacheKey = "statistik_pasar_filter_{$request->data}_{$request->periode}";

        $response = Cache::remember($cacheKey, 86400, function () use ($request) {
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

            return [
                'data' => $dpp,
                'jumlahHari' => $jumlahHari
            ];
        });

        return response()->json($response);
    }



    public function statistik_jenis_bahan_pokok_filter(Request $request)
    {
        $cacheKey = "statistik_jenis_bahan_pokok_filter_{$request->data}_{$request->periode}";

        $response = Cache::remember($cacheKey, 86400, function () use ($request) {
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

            return [
                'data' => $dpp,
                'jumlahHari' => $jumlahHari
            ];
        });

        return response()->json($response);
    }

}
