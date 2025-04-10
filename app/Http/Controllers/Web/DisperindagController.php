<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DPP;
use Illuminate\Http\Request;

class DisperindagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dpp = DPP::all();
        return view('admin.admin-disperindag', [
            'data' => $dpp
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin-create-disperindag', [
            'title' => 'Tambah Data',
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
    public function show(Dpp $dpp)
    {
        $dpp = DPP::all();
        return view('admin.admin-disperindag', [
            'data' => $dpp
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dpp $dpp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dpp $dpp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dpp $dpp)
    {
        //
    }
}
