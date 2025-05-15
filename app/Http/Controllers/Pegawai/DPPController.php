<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\DPP;
use App\Models\Pasar;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use App\Http\Controllers\Controller;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DPPController extends Controller
{
    public function index(Request $request)
    {
        $date = Carbon::createFromFormat('F Y', $request->periode);
        $month = $date->month;
        $year = $date->year;

        $dpp = DPP::join('pasar', 'dinas_perindustrian_perdagangan.pasar_id', '=', 'pasar.id')
            ->join('jenis_bahan_pokok', 'dinas_perindustrian_perdagangan.jenis_bahan_pokok_id', '=', 'jenis_bahan_pokok.id')
            ->whereMonth('tanggal_dibuat', $month)
            ->whereYear('tanggal_dibuat', $year)
            ->where('pasar.nama_pasar', $request->pasar)
            ->where('jenis_bahan_pokok.nama_bahan_pokok', $request->bahan_pokok)
            ->selectRaw("
                jenis_bahan_pokok.nama_bahan_pokok as jenis_bahan_pokok,
                dinas_perindustrian_perdagangan.kg_harga,
                dinas_perindustrian_perdagangan.tanggal_dibuat,
                pasar.nama_pasar as pasar,
                DAY(tanggal_dibuat) as hari
            ")
            ->get();
            
        // dd($dpp);

        return response()->json([
            'data' => $dpp
        ]);
    }

    public function konversi_nama_bulan_id($date)
    {
        $mapBulan = [
            'January'   => 'Januari',
            'February'  => 'Februari',
            'March'     => 'Maret',
            'April'     => 'April',
            'May'       => 'Mei',
            'June'      => 'Juni',
            'July'      => 'Juli',
            'August'   => 'Agustus',
            'September' => 'September',
            'October'   => 'Oktober',
            'November'  => 'November',
            'December'  => 'Desember'
        ];

        $bulanEn = Carbon::createFromFormat('Y-m', $date)->format('F');
        $bulanId = $mapBulan[$bulanEn];

        return $bulanId;
    }


    public function filter(Request $request)
    {
        $carbonDate = Carbon::createFromFormat('Y-m', $request->periode);
        $bulanId = $this->konversi_nama_bulan_id($request->periode);
        $jumlahHari = $carbonDate->daysInMonth;

        $dpp = DPP::select(
                    'jenis_bahan_pokok.nama_bahan_pokok as jenis_bahan_pokok',
                    'dinas_perindustrian_perdagangan.kg_harga',
                    'dinas_perindustrian_perdagangan.tanggal_dibuat',
                    'pasar.nama_pasar as pasar'
                )
                ->join('pasar', 'dinas_perindustrian_perdagangan.pasar_id', '=', 'pasar.id')
                ->join('jenis_bahan_pokok', 'dinas_perindustrian_perdagangan.jenis_bahan_pokok_id', '=', 'jenis_bahan_pokok.id')
                ->where('pasar.nama_pasar', $request->data)
                ->whereRaw("DATE_FORMAT(dinas_perindustrian_perdagangan.tanggal_dibuat, '%Y-%m') = ?", [$request->periode])
                ->get()
                ->groupBy('jenis_bahan_pokok')
                // dd($dpp);
                ->map(function($items) {
                    $row = [
                        'pasar' => $items[0]->pasar,
                        'jenis_bahan_pokok' => $items[0]->jenis_bahan_pokok,
                        'harga_per_tanggal' => [],
                    ];

                    foreach ($items as $item) {
                        $tanggal = (int) date('d', strtotime($item->tanggal_dibuat));
                        $row['harga_per_tanggal'][$tanggal] = $item->kg_harga;
                    }

                    return $row;
                });

        return response()->json([
            'data' => $dpp,
            'bulan' => $bulanId,
            'jumlahHari' => $jumlahHari
        ]);
    }

    public function listItem(Request $request, $namaBahanPokok)
    {
        try {
            $data = DPP::join('pasar', 'dinas_perindustrian_perdagangan.pasar_id', '=', 'pasar.id')
                ->join('jenis_bahan_pokok', 'dinas_perindustrian_perdagangan.jenis_bahan_pokok_id', '=', 'jenis_bahan_pokok.id')
                ->where('jenis_bahan_pokok.nama_bahan_pokok', $namaBahanPokok)
                ->where('pasar.nama_pasar', $request->pasar)
                ->whereRaw("DATE_FORMAT(dinas_perindustrian_perdagangan.tanggal_dibuat, '%Y-%m') = ?", [$request->periode])
                ->select(
                    'dinas_perindustrian_perdagangan.id as dpp_id',
                    'dinas_perindustrian_perdagangan.*',
                    'pasar.nama_pasar',
                    'jenis_bahan_pokok.nama_bahan_pokok'
                )
                ->get()
                ->map(function($item) {
                    $carbon = Carbon::parse($item->tanggal_dibuat);
                    $bulanEn = $carbon->format('Y-m');
                    $bulanId = $this->konversi_nama_bulan_id($bulanEn);
                    $item->tanggal_dibuat = $carbon->format('d') . ' ' . $bulanId . ' ' . $carbon->format('Y');
                    return $item;
                });
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
        // dd($request);
        try {
            $validated = $request->validate([
                'pasar_id' => 'required|exists:pasar,id',
                'jenis_bahan_pokok_id' => 'required|exists:jenis_bahan_pokok,id',
                'kg_harga' => 'required|integer',
            ]);

            // dd($request);

            $validated['tanggal_dibuat'] = now();
            $validated['user_id'] = 1;

            $dpp = DPP::create($validated);
            
            $data_stored = JenisBahanPokok::select('nama_bahan_pokok')->where('id', $dpp->jenis_bahan_pokok_id)->first();
            $riwayatStore = [
                'user_id' => 2,
                'komoditas' => $data_stored->nama_bahan_pokok,
                'aksi' => 'buat',
            ];
            
            Riwayat::create($riwayatStore);
            
            // dd($data_stored);

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $data_stored
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
                'pasar' => 'required',
                'jenis_bahan_pokok' => 'required',
                'kg_harga' => 'required|integer',
                'tanggal_dibuat' => 'required|date'
            ]);

            
            $dpp->update($validated);
            
            $data_stored = JenisBahanPokok::select('nama_bahan_pokok')->where('id', $dpp->jenis_bahan_pokok_id)->first();
            $riwayatStore = [
                'user_id' => 2,
                'komoditas' =>  $data_stored->nama_bahan_pokok,
                'aksi' => 'ubah'
            ];
            Riwayat::create($riwayatStore);

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $data_stored,
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
            
            $data_stored = JenisBahanPokok::select('nama_bahan_pokok')->where('id', $dpp->jenis_bahan_pokok_id)->first();
            $riwayatStore = [
                'user_id' => 2,
                'komoditas' => $data_stored->nama_bahan_pokok,
                'aksi' => 'hapus'
            ];
            Riwayat::create($riwayatStore);

            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $data_stored,]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
