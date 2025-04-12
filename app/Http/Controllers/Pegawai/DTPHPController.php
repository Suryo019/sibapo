<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\DTPHP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DTPHPController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $data = DTPHP::all();
        return response()->json($data);
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'jenis_komoditas' => 'required|string',
                // 'tanggal_input' => 'required|date',
                'ton_volume_produksi' => 'required|numeric',
                'hektar_luas_panen' => 'required|numeric'
            ]);
    
            // Tambahkan data tambahan kalau dibutuhkan, misalnya user_id
            $validated['tanggal_input'] = now();
            $validated['user_id'] = 1;
    
            $dtphp = DTPHP::create($validated);
    
            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dtphp
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
        $dtphp = DTPHP::find($id);

        if (!$dtphp) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'jenis_komoditas' => 'sometimes|string',
            'tanggal_input' => 'sometimes|date',
            'ton_volume_produksi' => 'sometimes|numeric',
            'hektar_luas_panen' => 'sometimes|numeric'
        ]);

        $dtphp->update($request->all());

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $dtphp
        ]);
    }    

    // Menghapus data
    public function destroy($id)
    {
        $dtphp = DTPHP::find($id);

        if (!$dtphp) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $dtphp->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
