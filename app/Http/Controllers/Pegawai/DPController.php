<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\DP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class DPController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        try {
            $dp = DP::whereYear('tanggal_input', 2025)
            ->where('jenis_ikan', 'Tongkol')
            ->select('jenis_ikan', 'ton_produksi')
            ->get();

            return response()->json([
                'data' => $dp
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function listItem($namaIkan)
    {
        try {
            $data = DP::where('jenis_ikan', $namaIkan)
            ->whereYear('tanggal_input', 2025)
            ->get();
            return response()->json(['data' => $data]);
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
        try{
            $validated = $request->validate([
                // 'tanggal_input' => 'required|date',
                'jenis_ikan' => 'required|string',
                'ton_produksi' => 'required|numeric'
            ]);
            
            $validated['tanggal_input'] = now();
            $validated['user_id'] = 1;
            $validated['aksi'] = 'buat';
            
            $dp = DP::create($validated);

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dp
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

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
            
            $dp = DP::find($id);
            
            if (!$dp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            
            $request->validate([
                'tanggal_input' => 'required|date',
                'jenis_ikan' => 'required|string',
                'ton_produksi' => 'required|numeric'
            ]);

            $validated['aksi'] = 'ubah';

            $dp->update($request->all());
            
            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $dp
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
            $dp = DP::find($id);

            if (!$dp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $dp->aksi = 'hapus';
            $dp->save();


            $dp->delete();

            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $dp]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}