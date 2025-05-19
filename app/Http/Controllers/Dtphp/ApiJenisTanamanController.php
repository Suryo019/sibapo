<?php

namespace App\Http\Controllers\Dtphp;

use App\Models\JenisTanaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ApiJenisTanamanController extends Controller
{
    public function index()
    {
        $data = JenisTanaman::with('dtphp')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tanaman' => 'required|string|max:255',
        ]);
        
        $nama_tanaman = JenisTanaman::create($validated);

        return response()->json([
            'message' => 'Jenis Tanaman berhasil ditambahkan',
            'data' => $nama_tanaman
        ], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $nama_tanaman = JenisTanaman::find($id);

            if (!$nama_tanaman) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $validated = $request->validate([
                'nama_tanaman' => 'sometimes|required|string|max:255'
            ]);

            $nama_tanaman->update($validated);

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $nama_tanaman
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
        $nama_tanaman = JenisTanaman::find($id);

        if (!$nama_tanaman) {
            return response()->json(['message' => 'Jenis Tanaman tidak ditemukan'], 404);
        }

        $nama_tanaman->delete();

        return response()->json(['message' => 'Jenis Tanaman berhasil dihapus']);
    }
}
