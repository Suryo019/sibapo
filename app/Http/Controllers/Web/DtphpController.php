<?php

namespace App\Http\Controllers\Web;

use App\Models\DTPHP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DtphpController extends Controller
{
    // View
    public function index()
    {
        $dtphp = DTPHP::all();
        return view('admin.dtphp.admin-dtphp', [
            'title' => 'Data Tanaman',
            'data' => $dtphp
        ]);
    }

    // Create
    public function create()
    {
        return view('admin.dtphp.admin-create-dtphp', [
            'title' => 'Tambah Data'
        ]);
    }

    public function store(Request $request)
    {
        //
    }
    
    public function show(DTPHP $dTPHP)
    {
        //
    }    

    public function edit(DTPHP $dTPHP)
    {
        return view('admin.dtphp.admin-update-dtphp', [
            'title' => 'Ubah Data'
        ]);
    }

    public function update(Request $request, DTPHP $dTPHP)
    {
        //
    }

    public function destroy(DTPHP $dTPHP)
    {
        //
    }
}
