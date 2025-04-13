<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\DKPP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DKPPController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $data = DKPP::all();
        return response()->json($data);
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'jenis_komoditas' => 'required|string',
                // 'tanggal_input' => 'required|date',
                'ton_ketersediaan' => 'required|numeric',
                'ton_kebutuhan_perminggu' => 'required|numeric',
                'ton_neraca_mingguan' => 'required|numeric',
                'keterangan' => 'nullable|string'
            ]);
            
            $validated['tanggal_input'] = now();
            $validated['user_id'] = 1;
            
            $dkpp = DKPP::create($validated);
            
            
            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dkpp
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
        try{
            $dkpp = DKPP::find($id);

            if (!$dkpp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
    
            $request->validate([
                'jenis_komoditas' => 'required|string',
                'tanggal_input' => 'required|date',
                'ton_ketersediaan' => 'required|numeric',
                'ton_kebutuhan_perminggu' => 'required|numeric',
                'ton_neraca_mingguan' => 'required|numeric',
                'keterangan' => 'nullable|string'
            ]);
    
            $dkpp->update($request->all());
    
            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $dkpp
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $th->getMessage()
            ], 500);
        }
    }    

    // Menghapus data
    public function destroy($id)
    {
        $dkpp = DKPP::find($id);

        if (!$dkpp) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $dkpp->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
