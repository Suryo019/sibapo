<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\DPP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DPPController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $data = DPP::all();
        return response()->json($data);
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'pasar' => 'required|string',
            'jenis_bahan_pokok' => 'required|string',
            'kg_harga' => 'required|integer',
            'tanggal_dibuat' => 'required|date'
        ]);

        $dpp = DPP::create($request->all());

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $dpp
        ], 201);
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        $dpp = DPP::find($id);

        if (!$dpp) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'pasar' => 'required|string',
            'jenis_bahan_pokok' => 'required|string',
            'kg_harga' => 'required|integer',
            'tanggal_dibuat' => 'required|date'
        ]);

        $dpp->update($request->all());

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $dpp
        ]);
    }    

    // Menghapus data
    public function destroy($id)
    {
        $dpp = DPP::find($id);

        if (!$dpp) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $dpp->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}

