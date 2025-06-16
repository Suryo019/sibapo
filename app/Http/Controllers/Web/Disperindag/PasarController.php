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
            'title' => 'TABEL DATA PASAR',
            'data' => $data
        ]);
    }

    public function create()
    {
        $pasar = Pasar::all();
        return view('admin.disperindag.admin-create-pasar-disperindag', [
            'title' => 'TAMBAH DATA PASAR',
            'markets' => $pasar,
        ]);
    }

    public function edit(Pasar $pasar)
    {
        return view('admin.disperindag.admin-update-pasar-disperindag', [
            'title' => 'UBAH DATA PASAR',
            'data' => $pasar,
        ]);
    }
}
