<?php

namespace App\Http\Controllers\Web;

use App\Models\DP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerikananController extends Controller
{
    // View
    public function index()
    {
        $perikanan = DP::all();
        return view('admin.perikanan.admin-perikanan', [
            'title' => 'Data Tanaman',
            'data' => $perikanan
        ]);
    }

    // Create
    public function create()
    {
        return view('admin.perikanan.admin-create-perikanan', [
            'title' => 'Tambah Data'
        ]);
    }

    public function store(Request $request)
    {
        //
    }
    
    public function show(DP $dP)
    {
        //
    }    

    public function edit(DP $perikanan)
    {
        return view('admin.perikanan.admin-update-perikanan', [
            'title' => 'Ubah Data',
            'data' => $perikanan,
        ]);
    }

    public function update(Request $request, DP $dP)
    {
        //
    }

    public function destroy(DP $dP)
    {
        //
    }
    
    public function detail()
    {
        Carbon::setLocale('id');
    }
}