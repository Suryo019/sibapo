<?php

namespace App\Http\Controllers\Web\Dtphp;

use App\Models\JenisTanaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisTanamanController extends Controller
{
    public function index()
    {
        $data = JenisTanaman::all();

        return view('admin.dtphp.admin-tanaman-dtphp', [
            'title' => 'TABEL DATA TANAMAN',
            'data' => $data
        ]);
    }

    public function create()
    {
        $nama_tanaman = JenisTanaman::all();
        return view('admin.dtphp.admin-create-tanaman-dtphp', [
            'title' => 'TAMBAH DATA TANAMAN',
            'fishes' => $nama_tanaman,
        ]);
    }

    public function edit(JenisTanaman $jenis_tanaman)
    {
        return view('admin.dtphp.admin-update-tanaman-dtphp', [
            'title' => 'UBAH DATA TANAMAN',
            'data' => $jenis_tanaman,
        ]);
    }
}
