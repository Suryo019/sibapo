<?php

namespace App\Http\Controllers\Web\Pegawai;

use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use App\Http\Controllers\Controller;

class PegawaiBahanPokokController extends Controller
{
    public function index()
    {
        $data = JenisBahanPokok::all();

        return view('pegawai.disperindag.pegawai-bpokok-disperindag', [
            'title' => 'TABEL DATA BAHAN POKOK',
            'data' => $data
        ]);
    }

    public function create()
    {
        $bahan_pokok = JenisBahanPokok::all();
        return view('pegawai.disperindag.pegawai-create-bpokok-disperindag', [
            'title' => 'TAMBAH DATA BAHAN POKOK',
            'items' => $bahan_pokok,
        ]);
    }

    public function edit(JenisBahanPokok $bahanpokok)
    {
        return view('pegawai.disperindag.pegawai-update-bpokok-disperindag', [
            'title' => 'UBAH DATA BAHAN POKOK',
            'data' => $bahanpokok,
        ]);
    }
}
