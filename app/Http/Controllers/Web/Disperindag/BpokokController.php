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
            'title' => 'TAMBAH DATA BAHAN POKOK',
            'items' => $bahan_pokok,
        ]);
    }

    public function edit(JenisBahanPokok $bahan_pokok)
    {
        return view('admin.disperindag.admin-update-bpokok-disperindag', [
            'title' => 'UBAH DATA BAHAN POKOK',
            'data' => $bahan_pokok,
        ]);
    }

    
}
