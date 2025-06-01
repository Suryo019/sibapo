<?php

namespace App\Http\Controllers\Web\Dtphp;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotifikasiDtphpController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::with('role')
            ->where('role_id', 4)
            ->orderByDesc('tanggal_pesan')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_pesan)->isToday() ? 'Hari Ini'
                    : (\Carbon\Carbon::parse($item->tanggal_pesan)->isYesterday() ? 'Kemarin' : 'Sebelumnya');
            });
    
        return view('pegawai.dtphp.pegawai-notifikasi-dtphp', compact('notifikasis'));
    }
}
