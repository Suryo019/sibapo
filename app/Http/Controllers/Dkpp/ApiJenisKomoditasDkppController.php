<?php

namespace App\Http\Controllers\Dkpp;

use Illuminate\Http\Request;
use App\Models\JenisKomoditasDkpp;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ApiJenisKomoditasDkppController extends Controller
{
    public function index ()
    {
        $data = JenisKomoditasDkpp::with('dkpp')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_komoditas' => 'required|string|unique:jenis_komoditas_dkpp,nama_komoditas|max:255',
            ]);

            $nama_komoditas = JenisKomoditasDkpp::create($validated);

            return response()->json([
                'message' => 'Jenis Komoditas berhasil ditambahkan',
                'data' => $nama_komoditas
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $nama_komoditas = JenisKomoditasDkpp::find($id);

            if (!$nama_komoditas) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $validated = [];

            if ($request->nama_komoditas != $nama_komoditas->nama_komoditas) {
                $validated = $request->validate([
                    'nama_komoditas' => 'required|string|unique:jenis_komoditas_dkpp,nama_komoditas|max:255'
                ]);
            } else {
                $validated['nama_komoditas'] = $nama_komoditas->nama_komoditas;
            }

            $nama_komoditas->update($validated);

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $nama_komoditas
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
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
        $nama_komoditas = JenisKomoditasDkpp::find($id);

        if (!$nama_komoditas) {
            return response()->json(['message' => 'Jenis Komoditas tidak ditemukan'], 404);
        }

        $nama_komoditas->delete();

        return response()->json(['message' => 'Jenis Komoditas berhasil dihapus', 'data' => $nama_komoditas]);
    }    
}
