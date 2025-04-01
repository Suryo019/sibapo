<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\DP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DPController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $data = DP::all();
        return response()->json($data);
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_input' => 'required|date',
            'jenis_ikan' => 'required|string',
            'ton_produksi' => 'required|numeric'
        ]);

        $dp = DP::create($request->all());

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $dp
        ], 201);
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        $dp = DP::find($id);

        if (!$dp) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'tanggal_input' => 'required|date',
            'jenis_ikan' => 'required|string',
            'ton_produksi' => 'required|numeric'
        ]);

        $dp->update($request->all());

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $dp
        ]);
    }    

    // Menghapus data
    public function destroy($id)
    {
        $dp = DP::find($id);

        if (!$dp) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $dp->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}