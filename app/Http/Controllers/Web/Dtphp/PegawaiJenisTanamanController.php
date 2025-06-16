<?php

namespace App\Http\Controllers\Web\Dtphp;

use App\Models\JenisTanaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PegawaiJenisTanamanController extends Controller
{
    public function index()
    {
        $data = JenisTanaman::all();

        return view('pegawai.dtphp.pegawai-tanaman-dtphp', [
            'title' => 'TABEL DATA TANAMAN',
            'data' => $data
        ]);
    }

    public function create()
    {
        $nama_tanaman = JenisTanaman::all();
        return view('pegawai.dtphp.pegawai-create-tanaman-dtphp', [
            'title' => 'TAMBAH DATA TANAMAN',
            'fishes' => $nama_tanaman,
        ]);
    }

    public function edit(JenisTanaman $jenis_tanaman)
    {
        return view('pegawai.dtphp.pegawai-update-tanaman-dtphp', [
            'title' => 'UBAH DATA TANAMAN',
            'data' => $jenis_tanaman,
        ]);
    }
}
