<?php

namespace App\Http\Controllers\Web\Disperindag;

use App\Models\JenisBahanPokok;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BpokokController extends Controller
{
    public function index()
    {
        $data = JenisBahanPokok::all();

        return view('admin.disperindag.admin-bpokok-disperindag', [
            'title' => 'TABEL DATA BAHAN POKOK',
            'data' => $data
        ]);
    }

    public function create()
    {
        $bahan_pokok = JenisBahanPokok::all();
        return view('admin.disperindag.admin-create-bpokok-disperindag', [
            'title' => 'Tambah Data',
            'items' => $bahan_pokok,
        ]);
    }

    public function edit(JenisBahanPokok $bahan_pokok)
    {
        return view('admin.disperindag.admin-update-bpokok-disperindag', [
            'title' => 'Ubah Data',
            'data' => $bahan_pokok,
        ]);
    }

    
}
