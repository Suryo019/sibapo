<?php

namespace App\Http\Controllers\Perikanan;

use App\Models\JenisIkan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ApiJenisIkanController extends Controller
{
    public function index()
    {
        $data = JenisIkan::with('dp')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ikan' => 'required|string|max:255|unique:jenis_ikan,nama_ikan',
        ]);
        
        $nama_ikan = JenisIkan::create($validated);

        return response()->json([
            'message' => 'Jenis Ikan berhasil ditambahkan',
            'data' => $nama_ikan
        ], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $nama_ikan = JenisIkan::find($id);

            if (!$nama_ikan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $validated = [
                'nama_ikan' => 'sometimes|required|string|max:255|unique:jenis_ikan,nama_ikan,' . $id,
            ];
            if ($validated['nama_ikan'] === $nama_ikan->nama_ikan) {
                unset($validated['nama_ikan']);
            }
            $validated = $request->validate($validated);
            
            $nama_ikan->update($validated);

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $nama_ikan
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $nama_ikan = JenisIkan::find($id);

        if (!$nama_ikan) {
            return response()->json(['message' => 'Jenis Ikan tidak ditemukan'], 404);
        }

        $nama_ikan->delete();

        return response()->json(['message' => 'Jenis Ikan berhasil dihapus']);
    }
}
