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
        try {
            $data = DPP::all();
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'pasar' => 'required|string',
                'jenis_bahan_pokok' => 'required|string',
                'kg_harga' => 'required|integer',
                // 'tanggal_dibuat' tidak perlu divalidasi jika kamu override nilainya
            ]);
            
            $validated['tanggal_dibuat'] = now();
            $validated['user_id'] = 1;
            
            $dpp = DPP::create($validated);
            
            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dpp
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
        try {
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
        try {
            $dpp = DPP::find($id);

            if (!$dpp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $dpp->delete();

            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}


