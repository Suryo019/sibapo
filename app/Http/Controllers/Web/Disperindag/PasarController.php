<?php

namespace App\Http\Controllers\Web\Disperindag;

use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasarController extends Controller
{
    public function index()
    {
        $data = Pasar::all();

        return view('admin.disperindag.admin-pasar-disperindag', [
            'title' => 'Data Pasar',
            'data' => $data
        ]);
    }

    public function create()
    {
        $pasar = Pasar::all();
        return view('admin.disperindag.admin-create-pasar-disperindag', [
            'title' => 'Tambah Data',
            'markets' => $pasar,
        ]);
    }

    public function edit(Pasar $pasar)
    {
        return view('admin.disperindag.admin-update-pasar-disperindag', [
            'title' => 'Ubah Data',
            'data' => $pasar,
        ]);
    }
}
