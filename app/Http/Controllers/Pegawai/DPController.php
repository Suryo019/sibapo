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
        try{
            $validated = $request->validate([
                // 'tanggal_input' => 'required|date',
                'jenis_ikan' => 'required|string',
                'ton_produksi' => 'required|numeric'
            ]);
            
            $validated['tanggal_input'] = now();
            $validated['user_id'] = 1;
            
            $dp = DP::create($validated);

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dp
            ], 201);
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $th->getMessage()
            ], 500);
        }
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