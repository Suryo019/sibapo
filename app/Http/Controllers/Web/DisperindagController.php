<?php

namespace App\Http\Controllers\Web;

use DateTime;
use Carbon\Carbon;
use App\Models\DPP;
use App\Models\Pasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\JenisBahanPokok;
use Illuminate\Database\Eloquent\Collection;

class DisperindagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodeUnikNama = DPP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_dibuat, "%Y-%m") as periode'))
        ->get()
        ->map(function ($item) {
            $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
            $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
            return $item->periode_indonesia;
        });

        // $dpp = DPP::all();

        $dpp = DPP::whereMonth('tanggal_dibuat', 4)
            ->whereYear('tanggal_dibuat', 2025)
            ->distinct()
            ->pluck('jenis_bahan_pokok');

        return view('admin.disperindag.admin-disperindag', [
            'title' => 'Data Aktivitas Harga Pasar',
            'data' => $dpp,
            'markets' => DPP::select('pasar')->distinct()->pluck('pasar'),
            'periods' => $periodeUnikNama,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasar = Pasar::all();
        $bahan_pokok = JenisBahanPokok::all();
        return view('admin.disperindag.admin-create-disperindag', [
            'title' => 'Tambah Data',
            'markets' => $pasar,
            'items' => $bahan_pokok,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // $dpp = DPP::all();
        // return view('admin.admin-disperindag', [
        //     'data' => $dpp
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dpp $disperindag)
    {
        return view('admin.disperindag.admin-update-disperindag', [
            'title' => 'Ubah Data',
            'data' => $disperindag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dpp $dpp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dpp $dpp)
    {
        //
    }

    public function filter(Request $request)
    {
        // Map bulan Indonesia ke Engleshhh
        $mapBulan = [
            'Januari'   => 'January',
            'Februari'  => 'February',
            'Maret'     => 'March',
            'April'     => 'April',
            'Mei'       => 'May',
            'Juni'      => 'June',
            'Juli'      => 'July',
            'Agustus'   => 'August',
            'September' => 'September',
            'Oktober'   => 'October',
            'November'  => 'November',
            'Desember'  => 'December'
        ];
    
        // Konversi input $request->periode dari ID ke EN
        $bagian = explode(' ', $request->periode ?? Carbon::now()->locale('en')->translatedFormat('F Y'));
        $bulanIndonesia = $bagian[0] ?? '';
        $tahun = $bagian[1] ?? now()->year;
    
        $bulanEn = $mapBulan[$bulanIndonesia] ?? $bulanIndonesia;
        $tanggalEn = "$bulanEn $tahun";
        $tanggalId = "$bulanIndonesia $tahun";
    
        // Validasi format dan konversi ke 'Y-m'
        if (array_key_exists($bulanIndonesia, $mapBulan) && Carbon::hasFormat($tanggalEn, 'F Y')) {
            $periodeUnikAngka = Carbon::createFromFormat('F Y', $tanggalEn)->format('Y-m');
        } else {
            $periodeUnikAngka = Carbon::now()->format('Y-m');
        }
    
        $pasar = $request->pasar ?? 'Pasar Tanjung';
    
        return [$tanggalId, $periodeUnikAngka, $pasar];
    }

    public function detail(Request $request)
    {
        Carbon::setLocale('id');

        $data = $this->filter($request);

        // Ambil periode unik dari data dan ubah ke format Indonesia
        $periodeUnikNama = DPP::select(DB::raw('DISTINCT DATE_FORMAT(tanggal_dibuat, "%Y-%m") as periode'))
            ->get()
            ->map(function ($item) {
                $carbonDate = Carbon::createFromFormat('Y-m', $item->periode);
                $item->periode_indonesia = $carbonDate->translatedFormat('F Y');
                return $item->periode_indonesia;
            });

        $tanggalId = $data[0];

        // Default periode
        $periodeUnikAngka = $data[1];
    
        // Default pasar
        $pasar = $data[2];
    
        // Hitung jumlah hari di bulan
        $splitPeriode = explode('-', $periodeUnikAngka);
        $jumlahHari = Carbon::createFromDate($splitPeriode[0], $splitPeriode[1])->daysInMonth;
    
        // Ambil data DPP berdasarkan periode dan pasar
        $dppHargaHari = DPP::whereRaw('DATE_FORMAT(tanggal_dibuat, "%Y-%m") = ?', [$periodeUnikAngka])
            ->when($pasar, function ($query) use ($pasar) {
                return $query->where('pasar', $pasar);
            })
            ->get()
            ->groupBy('jenis_bahan_pokok')
            ->map(function ($items) {
                $row = [
                    'id' => $items[0]->id,
                    'user_id' => $items[0]->user_id,
                    'pasar' => $items[0]->pasar,
                    'jenis_bahan_pokok' => $items[0]->jenis_bahan_pokok,
                    'gambar_bahan_pokok' => $items[0]->gambar_bahan_pokok,
                    'harga_per_tanggal' => [],
                    'data_asli' => $items, // Optional untuk debugging
                ];
    
                foreach ($items as $item) {
                    $tanggal = (int) date('d', strtotime($item->tanggal_dibuat));
                    $row['harga_per_tanggal'][$tanggal] = $item->kg_harga;
                }
    
                return $row;
            })->values();
    
        return view('admin.disperindag.admin-disperindag-detail', [
            'title' => 'Dinas Perindustrian dan Perdagangan',
            'data' => $dppHargaHari,
            'markets' => DPP::select('pasar')->distinct()->pluck('pasar'),
            'marketFiltered' => $pasar,
            'periods' => $periodeUnikNama,
            'period' => $tanggalId,
            'splitNumberPeriod' => $splitPeriode,
            'daysInMonth' => $jumlahHari,
        ]);
    }
}
