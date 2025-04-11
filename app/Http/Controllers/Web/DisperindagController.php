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
    public function edit(Dpp $dpp)
    {
        return view('admin.disperindag.admin-update-disperindag', [
            'title' => 'Ubah Data',
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

        $dpp = DPP::all();
        $periodeUnik = DPP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_dibuat, "%Y-%m") as periode'))
                    ->get()
                    ->map(function ($item) {
                        $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
                        $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
                        return $item->periode_indonesia;
                    });
    

        return view('admin.disperindag.admin-disperindag-detail', [
            'title' => 'Dinas Perindustrian dan Perdagangan',
            'data' => $dpp,
            'markets' => DPP::select('pasar')->distinct()->pluck('pasar'),
            'periods' => $periodeUnik,
        ]);
    }
}
