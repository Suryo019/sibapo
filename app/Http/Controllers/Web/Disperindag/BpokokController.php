<?php

namespace App\Http\Controllers\Web\Disperindag;

use App\Models\BahanPokok;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BpokokController extends Controller
{
    public function index()
    {
        $data = BahanPokok::all();

        return view('admin.disperindag.admin-bpokok-disperindag', [
            'title' => 'Data Bahan Pokok',
            'data' => $data
        ]);
    }

    public function create()
    {
        $bpokok = BahanPokok::all();
        return view('admin.disperindag.admin-create-bpokok-disperindag', [
            'title' => 'Tambah Data',
            'items' => $bpokok,
        ]);
    }

    public function edit(BahanPokok $bpokok)
    {
        return view('admin.disperindag.admin-update-bpokok-disperindag', [
            'title' => 'Ubah Data',
            'data' => $bpokok,
        ]);
    }
}
