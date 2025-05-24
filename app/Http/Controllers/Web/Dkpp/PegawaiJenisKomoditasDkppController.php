<?php

namespace App\Http\Controllers\Web\Dkpp;

use Illuminate\Http\Request;
use App\Models\JenisKomoditasDkpp;
use App\Http\Controllers\Controller;

class PegawaiJenisKomoditasDkppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = JenisKomoditasDkpp::all();

        return view('pegawai.dkpp.pegawai-komoditas-dkpp', [
            'title' => 'Data Jenis Komoditas',
            'data' => $data
        ]);
    }

    public function create()
    {
        $nama_komoditas = JenisKomoditasDkpp::all();
        return view('pegawai.dkpp.pegawai-create-komoditas-dkpp', [
            'title' => 'Tambah Data',
            'commodities' => $nama_komoditas,
        ]);
    }

    public function edit($id)
    {
        // dd($jenis_komoditas);
        $jenis_komoditas = JenisKomoditasDkpp::findOrFail($id);
        return view('pegawai.dkpp.pegawai-update-komoditas-dkpp', [
            'title' => 'Ubah Data',
            'data' => $jenis_komoditas,
        ]);
    }
}
