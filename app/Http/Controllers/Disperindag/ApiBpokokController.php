<?php

namespace App\Http\Controllers\Disperindag;

use App\Models\JenisBahanPokok;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ApiBpokokController extends Controller
{
    public function index()
    {
        $data = JenisBahanPokok::with('dpp')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bahan_pokok' => 'required|string|max:255|unique:jenis_bahan_pokok,nama_bahan_pokok',
            'gambar_bahan_pokok' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar_bahan_pokok')) {
            $file = $request->file('gambar_bahan_pokok');
        
            if ($file->isValid()) {
                $hash = md5_file($file->getRealPath());
        
                $extension = $file->getClientOriginalExtension();
                $filename = $hash . '.' . $extension;
        
                $path = 'gambarBpokokDisperindag/' . $filename;
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->putFileAs('gambarBpokokDisperindag', $file, $filename);
                }
        
                $validated['gambar_bahan_pokok'] = $path;
            } else {
                return response()->json(['message' => 'File tidak valid'], 400);
            }
        }

        $bpokok = JenisBahanPokok::create($validated);

        return response()->json([
            'message' => 'Bahan pokok berhasil ditambahkan',
            'data' => $bpokok
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $bpokok = JenisBahanPokok::find($id);

        if (!$bpokok) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = [
            'nama_bahan_pokok' => 'sometimes|required|string|max:255|unique:jenis_bahan_pokok,nama_bahan_pokok,' . $bpokok->id,
            'gambar_bahan_pokok' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
        
        if (isset($validated['nama_bahan_pokok']) && $validated['nama_bahan_pokok'] === $bpokok->nama_bahan_pokok) {
            unset($validated['nama_bahan_pokok']);
        }
        $validated = $request->validate($validated);

        // Cek apakah ada gambar baru yang diupload
        if ($request->hasFile('gambar_bahan_pokok')) {
            $file = $request->file('gambar_bahan_pokok');
        
            if ($file->isValid()) {
                $hash = md5_file($file->getRealPath());
        
                $extension = $file->getClientOriginalExtension();
                $filename = $hash . '.' . $extension;
        
                $path = 'gambarBpokokDisperindag/' . $filename;
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->putFileAs('gambarBpokokDisperindag', $file, $filename);
                }
        
                $validated['gambar_bahan_pokok'] = $path;
            } else {
                return response()->json(['message' => 'File tidak valid'], 400);
            }
        }

        $bpokok->update($validated);

        return response()->json([
            'message' => 'Bahan pokok berhasil diperbarui',
            'data' => $bpokok
        ]);
    }

    public function destroy($id)
    {
        $bpokok = JenisBahanPokok::find($id);

        if (!$bpokok) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $bpokok->delete();

        return response()->json(['message' => 'Bahan pokok berhasil dihapus']);
    }
}
