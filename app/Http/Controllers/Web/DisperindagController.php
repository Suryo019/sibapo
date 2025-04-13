<?php

namespace App\Http\Controllers\Web;

use App\Models\DPP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DisperindagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dpp = DPP::all();
        return view('admin.disperindag.admin-disperindag', [
            'title' => 'Data Aktivitas Harga Pasar',
            'data' => $dpp
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.disperindag.admin-create-disperindag', [
            'title' => 'Tambah Data',
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
        // return view('admin.admin-disperindag', [
        //     'data' => $dpp
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dpp $disperindag)
    {
        return view('admin.disperindag.admin-update-disperindag', [
            'title' => 'Ubah Data',
            'data' => $disperindag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dpp $dpp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dpp $dpp)
    {
        //
    }

    public function detail()
    {
        Carbon::setLocale('id');

        $periodeUnikNama = DPP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_dibuat, "%Y-%m") as periode'))
                    ->get()
                    ->map(function ($item) {
                        $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
                        $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
                        return $item->periode_indonesia;
                    });
        $periodeUnikAngka = DPP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_dibuat, "%Y-%m") as periode'))
            ->get()
            ->map(function ($item) {
                return $item->periode;
            });

        // dd($periodeUnikAngka);
        $periode = explode('-', $periodeUnikAngka[1]);
        $jumlahHari = Carbon::createFromDate($periode[0], $periode[1])->daysInMonth;

        $periode = $periodeUnikAngka[1];

        // dd($periode);
        $dppHargaHari = DPP::whereRaw('DATE_FORMAT(tanggal_dibuat, "%Y-%m") = ?', [$periode])
        ->get()
        ->groupBy('jenis_bahan_pokok')
        ->map(function ($items) {
            // dd($items);
            $row = [
                'id' => $items[0]->id,
                'user_id' => $items[0]->user_id,
                'pasar' => $items[0]->pasar,
                'jenis_bahan_pokok' => $items[0]->jenis_bahan_pokok,
                'harga_per_tanggal' => [],
                'data_asli' => $items, // Optional, untuk keperluan detail/debug
            ];
    
            foreach ($items as $item) {
                $tanggal = (int) date('d', strtotime($item->tanggal_dibuat));
                $row['harga_per_tanggal'][$tanggal] = $item->kg_harga;
            }
    
            return $row;
        })->values();
    

        return view('admin.disperindag.admin-disperindag-detail', [
            'title' => 'Dinas Perindustrian dan Perdagangan',
            'data' => $dppHargaHari,
            'markets' => DPP::select('pasar')->distinct()->pluck('pasar'),
            'periods' => $periodeUnikNama,
            'numberPeriods' => $periodeUnikAngka,
            'daysInMonth' => $jumlahHari,
        ]);
    }
}
