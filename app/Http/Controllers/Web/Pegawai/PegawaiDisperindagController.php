<?php

namespace App\Http\Controllers\Web\Pegawai;

use Carbon\Carbon;
use App\Models\DPP;
use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PegawaiDisperindagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodeUnikNama = DPP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_dibuat, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dpp = DPP::all();

        $dpp = JenisBahanPokok::select('nama_bahan_pokok')->get();
        $markets = Pasar::select('nama_pasar')->get();

        return view('pegawai.disperindag.pegawai-disperindag', [
            'title' => 'Data Aktivitas Harga Pasar',
            'data' => $dpp,
            'markets' => $markets,
            'periods' => $periodeUnikNama,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasar = Pasar::all();
        $bahan_pokok = JenisBahanPokok::all();
        return view('pegawai.disperindag.pegawai-create-disperindag', [
            'title' => 'Tambah Data',
            'markets' => $pasar,
            'items' => $bahan_pokok,
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
        // return view('pegawai.pegawai-disperindag', [
        //     'data' => $dpp
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dpp $disperindag)
    {
        $pasar = Pasar::all();
        $bahan_pokok = JenisBahanPokok::all();
        return view('pegawai.disperindag.pegawai-update-disperindag', [
            'title' => 'Ubah Data',
            'data' => $disperindag,
            'markets' => $pasar,
            'items' => $bahan_pokok,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dpp $dpp)
    {
        //
    }

    public function dppDetail()
    {
        $pasar = Pasar::select('nama_pasar')->distinct()->get();
        return view('pegawai.disperindag.pegawai-disperindag-detail', [
            'title' => 'Dinas Perindustrian dan Perdagangan',
            'markets' => $pasar,
        ]);
    }
}
