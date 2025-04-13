<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DKPP;
use Illuminate\Http\Request;

class DkppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DKPP::all();
        return view('admin.dkpp.admin-dkpp', [
            'title' => 'Data Ketersediaan dan Kebutuhan Pangan Pokok',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dkpp.admin-create-dkpp', [
            'title' => 'Tambah Data'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DKPP $dKPP)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DKPP $dkpp)
    {
        return view('admin.dkpp.admin-update-dkpp', [
            'title' => 'Ubah Data',
            'data' => $dkpp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DKPP $dKPP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DKPP $dKPP)
    {
        //
    }
}
