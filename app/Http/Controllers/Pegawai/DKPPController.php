<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\DKPP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class DKPPController extends Controller
{
    public function index(Request $request)
    {
        try {
            // return response()->json(['data' => $request]);
            $date = Carbon::createFromFormat('F Y', $request->periode);
            $month = $date->month;
            $year = $date->year;

            $data = DKPP::whereYear('tanggal_input', $year)
            ->whereMonth('tanggal_input', $month)
            ->whereRaw('FLOOR((DAY(tanggal_input) - 1) / 7) + 1 = ?', (int) $request->minggu)
            ->select('jenis_komoditas', 'ton_ketersediaan', 'ton_kebutuhan_perminggu')
            ->get();
            
            return response()->json([
                'data' => $data,
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'jenis_komoditas' => 'required|string',
                'ton_ketersediaan' => 'required|numeric',
                'ton_kebutuhan_perminggu' => 'required|numeric',
            ]);

            $validated['tanggal_input'] = now();
            $validated['user_id'] = 1;
            $validated['ton_neraca_mingguan'] = $validated['ton_ketersediaan'] - $validated['ton_kebutuhan_perminggu'];

            $validated['keterangan'] = $validated['ton_neraca_mingguan'] > 0 ? 'Surplus' : ($validated['ton_neraca_mingguan'] < 0 ? 'Defisit' : 'Seimbang');

            $dkpp = DKPP::create($validated);

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $dkpp
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
            $dkpp = DKPP::find($id);

            if (!$dkpp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $validated = $request->validate([
                'jenis_komoditas' => 'required|string',
                'ton_ketersediaan' => 'required|numeric',
                'ton_kebutuhan_perminggu' => 'required|numeric',
            ]);

            $validated['tanggal_input'] = now();
            $validated['user_id'] = 1;
            $validated['ton_neraca_mingguan'] = $validated['ton_ketersediaan'] - $validated['ton_kebutuhan_perminggu'];

            $validated['keterangan'] = $validated['ton_neraca_mingguan'] > 0 ? 'Surplus' : ($validated['ton_neraca_mingguan'] < 0 ? 'Defisit' : 'Seimbang');

            $dkpp->update($validated);

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $dkpp
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
            $dkpp = DKPP::find($id);

            if (!$dkpp) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $dkpp->delete();

            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $dkpp]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
