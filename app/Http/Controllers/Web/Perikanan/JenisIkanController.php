<?php

namespace App\Http\Controllers\Web\Perikanan;

use App\Models\JenisIkan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisIkanController extends Controller
{
    public function index()
    {
        $data = JenisIkan::all();

        return view('admin.perikanan.admin-ikan-perikanan', [
            'title' => 'Data Jenis Ikan',
            'data' => $data
        ]);
    }

    public function create()
    {
        $nama_ikan = JenisIkan::all();
        return view('admin.perikanan.admin-create-ikan-perikanan', [
            'title' => 'Tambah Data',
            'fishes' => $nama_ikan,
        ]);
    }

    public function edit(JenisIkan $nama_ikan)
    {
        return view('admin.perikanan.admin-update-ikan-perikanan', [
            'title' => 'Ubah Data',
            'data' => $nama_ikan,
        ]);
    }
}
