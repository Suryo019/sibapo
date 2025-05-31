<?php

namespace App\Http\Controllers\Web\Perikanan;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotifikasiPerikananController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::with('role')
            ->where('role_id', 5)
            ->orderByDesc('tanggal_pesan')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_pesan)->isToday() ? 'Hari Ini'
                    : (\Carbon\Carbon::parse($item->tanggal_pesan)->isYesterday() ? 'Kemarin' : 'Sebelumnya');
            });
    
        return view('pegawai.perikanan.pegawai-notifikasi-perikanan', compact('notifikasis'));
    }
}