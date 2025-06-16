<?php

namespace App\Http\Controllers\Web\Pegawai;

use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PegawaiPasarController extends Controller
{
    public function index()
    {
        $data = Pasar::all();

        return view('pegawai.disperindag.pegawai-pasar-disperindag', [
            'title' => 'TABEL DATA PASAR',
            'data' => $data
        ]);
    }

    public function create()
    {
        $pasar = Pasar::all();
        return view('pegawai.disperindag.pegawai-create-pasar-disperindag', [
            'title' => 'TAMBAH DATA PASAR',
            'markets' => $pasar,
        ]);
    }

    public function edit(Pasar $pasar)
    {
        return view('pegawai.disperindag.pegawai-update-pasar-disperindag', [
            'title' => 'UBAH DATA PASAR',
            'data' => $pasar,
        ]);
    }
}
