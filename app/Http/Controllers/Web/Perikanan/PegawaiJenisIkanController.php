<?php

namespace App\Http\Controllers\Web\Perikanan;

use App\Models\JenisIkan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PegawaiJenisIkanController extends Controller
{
    public function index()
    {
        $data = JenisIkan::all();

        return view('pegawai.perikanan.pegawai-ikan-perikanan', [
            'title' => 'TABEL DATA IKAN',
            'data' => $data
        ]);
    }

    public function create()
    {
        $nama_ikan = JenisIkan::all();
        return view('pegawai.perikanan.pegawai-create-ikan-perikanan', [
            'title' => 'TAMBAH DATA IKAN',
            'fishes' => $nama_ikan,
        ]);
    }

    public function edit(JenisIkan $jenis_ikan)
    {
        return view('pegawai.perikanan.pegawai-update-ikan-perikanan', [
            'title' => 'UBAH DATA IKAN',
            'data' => $jenis_ikan,
        ]);
    }
}
