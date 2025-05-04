<?php

namespace App\Http\Controllers\Disperindag;

use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiPasarController extends Controller
{
    public function index()
    {
        $data = Pasar::with('dpp')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pasar' => 'required|string|max:255',
        ]);

        $pasar = Pasar::create($validated);

        return response()->json([
            'message' => 'Pasar berhasil ditambahkan',
            'data' => $pasar
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $pasar = Pasar::find($id);

        if (!$pasar) {
            return response()->json(['message' => 'Pasar tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nama_pasar' => 'sometimes|required|string|max:255',
        ]);

        $pasar->update($validated);

        return response()->json([
            'message' => 'Pasar berhasil diperbarui',
            'data' => $pasar
        ]);
    }

    public function destroy($id)
    {
        $pasar = Pasar::find($id);

        if (!$pasar) {
            return response()->json(['message' => 'Pasar tidak ditemukan'], 404);
        }

        $pasar->delete();

        return response()->json(['message' => 'Pasar berhasil dihapus']);
    }
}
