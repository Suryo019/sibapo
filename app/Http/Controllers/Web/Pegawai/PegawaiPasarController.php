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
            'title' => 'Data Pasar',
            'data' => $data
        ]);
    }

    public function create()
    {
        $pasar = Pasar::all();
        return view('pegawai.disperindag.pegawai-create-pasar-disperindag', [
            'title' => 'Tambah Data',
            'markets' => $pasar,
        ]);
    }

    public function edit(Pasar $pasar)
    {
        return view('pegawai.disperindag.pegawai-update-pasar-disperindag', [
            'title' => 'Ubah Data',
            'data' => $pasar,
        ]);
    }
}
