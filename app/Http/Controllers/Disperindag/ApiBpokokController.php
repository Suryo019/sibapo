<?php

namespace App\Http\Controllers\Disperindag;

use App\Models\BahanPokok;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiBpokokController extends Controller
{
    public function index()
    {
        $data = BahanPokok::with('dpp')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bpokok' => 'required|string|max:255',
            'gambar_bpokok' => 'required|string|max:255',
        ]);

        $bpokok = BahanPokok::create($validated);

        return response()->json([
            'message' => 'Bahan pokok berhasil ditambahkan',
            'data' => $bpokok
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $bpokok = BahanPokok::find($id);

        if (!$bpokok) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nama_bpokok' => 'sometimes|required|string|max:255',
            'gambar_bpokok' => 'sometimes|required|string|max:255',
        ]);

        $bpokok->update($validated);

        return response()->json([
            'message' => 'Bahan pokok berhasil diperbarui',
            'data' => $bpokok
        ]);
    }

    public function destroy($id)
    {
        $bpokok = BahanPokok::find($id);

        if (!$bpokok) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $bpokok->delete();

        return response()->json(['message' => 'Bahan pokok berhasil dihapus']);
    }
}
