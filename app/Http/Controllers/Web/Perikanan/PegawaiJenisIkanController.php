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
            'title' => 'Data Jenis Ikan',
            'data' => $data
        ]);
    }

    public function create()
    {
        $nama_ikan = JenisIkan::all();
        return view('pegawai.perikanan.pegawai-create-ikan-perikanan', [
            'title' => 'Tambah Data',
            'fishes' => $nama_ikan,
        ]);
    }

    public function edit(JenisIkan $jenis_ikan)
    {
        return view('pegawai.perikanan.pegawai-update-ikan-perikanan', [
            'title' => 'Ubah Data',
            'data' => $jenis_ikan,
        ]);
    }
}
