<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiAdminController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::with('role')
            ->where('role_id', 1)
            ->orderByDesc('tanggal_pesan')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_pesan)->isToday() ? 'Hari Ini'
                    : (\Carbon\Carbon::parse($item->tanggal_pesan)->isYesterday() ? 'Kemarin' : 'Sebelumnya');
            });
    
        return view('admin.admin-notifikasi', compact('notifikasis'));
    }
}
