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
        // TAK UPDATE
        try {
            // return response()->json(['data' => $request]);
            $date = Carbon::createFromFormat('F Y', $request->periode);
            // $date = Carbon::createFromFormat('F Y', 'April 2025');
            $month = $date->month;
            $year = $date->year;

            $data = DKPP::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('minggu', $request->minggu)
            ->select('jenis_komoditas', 'ton_ketersediaan', 'ton_kebutuhan_perminggu')
            ->get();

            // dd($data);
            
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

            $currentWeek = now()->weekOfMonth;


            $validated['minggu'] = $currentWeek;
            $validated['user_id'] = 1;
            $validated['ton_neraca_mingguan'] = $validated['ton_ketersediaan'] - $validated['ton_kebutuhan_perminggu'];
            $validated['aksi'] = 'buat';

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
                'minggu' => 'required|numeric',
            ]);

            $validated['user_id'] = 1;
            $validated['ton_neraca_mingguan'] = $validated['ton_ketersediaan'] - $validated['ton_kebutuhan_perminggu'];
            $validated['aksi'] = 'ubah';

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

            $dkpp->aksi = 'hapus';
            $dkpp->save();

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
