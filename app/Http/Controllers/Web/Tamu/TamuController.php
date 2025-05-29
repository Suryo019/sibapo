<?php

namespace App\Http\Controllers\Web\Tamu;

use Carbon\Carbon;
use App\Models\DPP;
use Illuminate\Http\Request;
use App\Models\JenisBahanPokok;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pasar;

class TamuController extends Controller
{
    public function beranda()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $komoditasList = JenisBahanPokok::whereIn('id', function ($query) {
            $query->select('jenis_bahan_pokok_id')
                  ->from('dinas_perindustrian_perdagangan');
        })
        ->select('id', 'nama_bahan_pokok', 'gambar_bahan_pokok')
        ->distinct()
        ->get();

        // dd($komoditasList);

        $data = [];

        foreach ($komoditasList as $komoditas) {
            $dataHarga = DB::table('dinas_perindustrian_perdagangan')
                ->where('jenis_bahan_pokok_id', $komoditas->id)
                ->orderByDesc('tanggal_dibuat')
                ->take(2)
                ->pluck('kg_harga', 'tanggal_dibuat');

            $hargaTerbaru = $dataHarga->values()[0] ?? null;
            $hargaSebelumnya = $dataHarga->values()[1] ?? null;

            $selisih = null;
            $status = 'Tidak ada data';

            if (!is_null($hargaTerbaru) && !is_null($hargaSebelumnya)) {
                $selisih = $hargaTerbaru - $hargaSebelumnya;
                $status = $selisih > 0 ? 'Naik' : ($selisih < 0 ? 'Turun' : 'Stabil');
            }

            $data[] = [
                'komoditas' => $komoditas->nama_bahan_pokok,
                'gambar_komoditas' => $komoditas->gambar_bahan_pokok,
                'rata_rata_hari_ini' => round($hargaTerbaru, 2),
                'rata_rata_kemarin' => round($hargaSebelumnya, 2),
                'selisih' => round($selisih, 2),
                'status' => $status,
            ];
        }


        return view('tamu.beranda', [
            'title' => 'Beranda',
            'data' => $data,
            'kemarin' => Carbon::yesterday()->format('d F Y'),
        ]);
    }

    public function komoditas_filter()
    {
        return view('tamu.tamu-komoditas-filter', [
            'title' => 'Bahan Pokok',
            'kemarin' => Carbon::yesterday()->format('d F Y'),
        ]);
    }

    public function pasar_filter()
    {
        return view('tamu.tamu-pasar-filter', [
            'title' => 'Pasar',
            'kemarin' => Carbon::yesterday()->format('d F Y'),
        ]);
    }

    public function statistik()
    {
        // $dpp = DPP::all();
        $pasar = Pasar::select('nama_pasar')->distinct()->get();

        return view('tamu.tamu-statistik', [
            'title' => 'Statistik',
            // 'data' => $dpp,
            'markets' => $pasar,
        ]);
    }

    public function metadata()
    {
        $bahan_pokok = JenisBahanPokok::pluck('nama_bahan_pokok');
        return view('tamu.tamu-metadata', [
            'title' => 'Metadata',
            'bahanPokok' => $bahan_pokok,
        ]);
    }

    public function tentang_kami()
    {
        return view('tamu.tamu-tentang-kami', [
            'title' => 'Tentang Kami',
        ]);
    }

    public function hubungi_kami()
    {
        return view('tamu.tamu-hubungi-kami', [
            'title' => 'Hubungi Kami',
        ]);
    }
}
