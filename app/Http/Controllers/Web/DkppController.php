<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Models\DKPP;
use Illuminate\Http\Request;
use App\Models\JenisKomoditasDkpp;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DkppController extends Controller
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

        $currentWeek = now()->weekOfMonth;

        // $data = DKPP::all();
        return view('admin.dkpp.admin-dkpp', [
            'title' => 'Data Ketersediaan dan Kebutuhan Pangan Pokok',
            // 'data' => $data,
            'periods' => $periodeUnikNama,
            'currentWeek' => $currentWeek
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $komoditas = JenisKomoditasDkpp::all();
        return view('admin.dkpp.admin-create-dkpp', [
            'title' => 'Tambah Data',
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
        return view('admin.dkpp.admin-update-dkpp', [
            'title' => 'Ubah Data',
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
        $currentWeek = floor((now()->day - 1) / 7) + 1;

        return view('admin.dkpp.admin-dkpp-detail', [
            'title' => 'Data Ketersediaan dan Kebutuhan Pangan Pokok',
            'currentWeek' => $currentWeek,
        ]);
    }
}
