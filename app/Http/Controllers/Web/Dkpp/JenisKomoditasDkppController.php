<?php

namespace App\Http\Controllers\Web\Dkpp;

use Illuminate\Http\Request;
use App\Models\JenisKomoditasDkpp;
use App\Http\Controllers\Controller;

class JenisKomoditasDkppController extends Controller
{
    public function index()
    {
        $data = JenisKomoditasDkpp::all();

        return view('admin.dkpp.admin-komoditas-dkpp', [
            'title' => 'TABEL DATA KOMODITAS',
            'data' => $data
        ]);
    }

    public function create()
    {
        $nama_komoditas = JenisKomoditasDkpp::all();
        return view('admin.dkpp.admin-create-komoditas-dkpp', [
            'title' => 'TAMBAH DATA KOMODITAS',
            'commodities' => $nama_komoditas,
        ]);
    }

    public function edit($id)
    {
        // dd($jenis_komoditas);
        $jenis_komoditas = JenisKomoditasDkpp::findOrFail($id);
        return view('admin.dkpp.admin-update-komoditas-dkpp', [
            'title' => 'UBAH DATA KOMODITAS',
            'data' => $jenis_komoditas,
        ]);
    }
}
