<?php

namespace App\Http\Controllers\Disperindag;

use App\Models\BahanPokok;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
            'gambar_bpokok' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar_bpokok')) {
            $file = $request->file('gambar_bpokok');
        
            if ($file->isValid()) {
                $hash = md5_file($file->getRealPath());
        
                $extension = $file->getClientOriginalExtension();
                $filename = $hash . '.' . $extension;
        
                $path = 'gambarBpokokDisperindag/' . $filename;
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->putFileAs('gambarBpokokDisperindag', $file, $filename);
                }
        
                $validated['gambar_bpokok'] = $path;
            } else {
                return response()->json(['message' => 'File tidak valid'], 400);
            }
        }

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
            'gambar_bpokok' => 'nullable|image|file|max:2048',
        ]);

        // Cek apakah ada gambar baru yang diupload
        if ($request->hasFile('gambar_bpokok')) {
            $file = $request->file('gambar_bpokok');
        
            if ($file->isValid()) {
                $hash = md5_file($file->getRealPath());
        
                $extension = $file->getClientOriginalExtension();
                $filename = $hash . '.' . $extension;
        
                $path = 'gambarBpokokDisperindag/' . $filename;
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->putFileAs('gambarBpokokDisperindag', $file, $filename);
                }
        
                $validated['gambar_bpokok'] = $path;
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
        $bpokok = BahanPokok::find($id);

        if (!$bpokok) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $bpokok->delete();

        return response()->json(['message' => 'Bahan pokok berhasil dihapus']);
    }
}
