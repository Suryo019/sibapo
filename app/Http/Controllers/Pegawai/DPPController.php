<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\DPP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DPPController extends Controller
{
    public function index(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('F Y', $request->periode);
            $month = $date->month;
            $year = $date->year;
            // return response()->json(['month' => $month, 'year' => $year]);
            $dpp = DPP::whereMonth('tanggal_dibuat', $month)
            ->whereYear('tanggal_dibuat', $year)
            ->where('pasar', $request->pasar)
            ->where('jenis_bahan_pokok', $request->bahan_pokok)
            ->selectRaw('jenis_bahan_pokok, pasar, kg_harga, tanggal_dibuat, DAY(tanggal_dibuat) as hari')
            ->get();

            return response()->json([
                'data' => $dpp
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function detailDataFilter(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('F Y', $request->periode);
            $month = $date->month;
            $year = $date->year;
            // return response()->json(['month' => $month, 'year' => $year]);
            $dpp = DPP::whereMonth('tanggal_dibuat', $month)
            ->whereYear('tanggal_dibuat', $year)
            ->where('pasar', $request->pasar)
            ->get();

            return response()->json([
                'data' => $dpp
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function listItem(Request $request, $namaBahanPokok)
    {
        try {
            $data = DPP::where('jenis_bahan_pokok', $namaBahanPokok)
                ->whereMonth('tanggal_dibuat', $request->periode_bulan)
                ->whereYear('tanggal_dibuat', $request->periode_tahun)
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
        try {
            $validated = $request->validate([
                'pasar' => 'required|string',
                'jenis_bahan_pokok' => 'required|string',
                'gambar_bahan_pokok' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'kg_harga' => 'required|integer',
            ]);

            $validated['tanggal_dibuat'] = now();
            $validated['user_id'] = 1;

            // Up gambar
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
            
            $dpp = DPP::create($validated);

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dpp
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

    public function update(Request $request, $id)
    {
        try {
            $dpp = DPP::find($id);

            if (!$dpp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $validated = $request->validate([
                'pasar' => 'required|string',
                'jenis_bahan_pokok' => 'required|string',
                'gambar_bahan_pokok' => 'nullable|image|file|max:2048',
                'kg_harga' => 'required|integer',
                'tanggal_dibuat' => 'required|date'
            ]);

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
            

            $dpp->update($validated);

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $dpp
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
        try {
            $dpp = DPP::find($id);

            if (!$dpp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            if ($dpp->gambar_bahan_pokok) {
                Storage::delete($dpp->gambar_bahan_pokok);
            }

            $dpp->delete();

            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $dpp]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
