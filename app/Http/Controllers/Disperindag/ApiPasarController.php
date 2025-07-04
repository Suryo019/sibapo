<?php

namespace App\Http\Controllers\Disperindag;

use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

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
            'nama_pasar' => 'required|string|max:255|unique:pasar,nama_pasar',
        ]);

        $pasar = Pasar::create($validated);

        return response()->json([
            'message' => 'Pasar berhasil ditambahkan',
            'data' => $pasar
        ], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $pasar = Pasar::find($id);

            if (!$pasar) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $validated = [
                'nama_pasar' => 'sometimes|required|string|max:255|unique:pasar,nama_pasar,' . $id,
            ];

            if ($validated['nama_pasar'] === $pasar->nama_pasar) {
                unset($validated['nama_pasar']);
            }

            $validated = $request->validate($validated);

            $pasar->update($validated);

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $pasar
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
        $pasar = Pasar::find($id);

        if (!$pasar) {
            return response()->json(['message' => 'Pasar tidak ditemukan'], 404);
        }

        $pasar->delete();

        return response()->json(['message' => 'Pasar berhasil dihapus']);
    }
}
