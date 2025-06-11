<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiAdminController extends Controller
{
    public function index(Request $request)
    {
        // $query = Notifikasi::with('role')->where('role_id', 1);
        $query = Notifikasi::with('role')->where('is_admin', 1);

        $notifikasis = $query->orderByDesc('tanggal_pesan')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal_pesan)->isToday() ? 'Hari Ini'
                    : (Carbon::parse($item->tanggal_pesan)->isYesterday() ? 'Kemarin' : 'Sebelumnya');
            });

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.partials.notifikasi-list', compact('notifikasis'))->render()
            ]);
        }

        return view('admin.admin-notifikasi', compact('notifikasis'));
    }

    public function filter(Request $request)
    {
        $query = Notifikasi::with('role')->where('is_admin', 1);

        // Apply filters
        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_completed', false);
            }
        }

        if ($request->filled('role')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('tanggal_pesan', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('tanggal_pesan', Carbon::yesterday());
                    break;
                case 'week':
                    $query->whereBetween('tanggal_pesan', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('tanggal_pesan', Carbon::now()->month)
                          ->whereYear('tanggal_pesan', Carbon::now()->year);
                    break;
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('pesan', 'like', "%{$searchTerm}%");
        }

        $notifikasis = $query->orderByDesc('tanggal_pesan')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal_pesan)->isToday() ? 'Hari Ini'
                    : (Carbon::parse($item->tanggal_pesan)->isYesterday() ? 'Kemarin' : 'Sebelumnya');
            });

        return response()->json([
            'success' => true,
            'data' => $notifikasis,
            'count' => $notifikasis->flatten()->count()
        ]);
    }

    public function getHeaderNotifications()
    {
        $recentNotifications = Notifikasi::with('role')
            // ->where('role_id', 1)
            ->where('is_admin', 1)
            ->orderByDesc('tanggal_pesan')
            ->limit(3)
            ->get();

        // $unreadCount = Notifikasi::where('role_id', 1)
        //     ->where('is_read', false)
        //     ->count();

        $unreadCount = Notifikasi::where('is_admin', 1)
            ->where('is_read', false)
            ->count();

        // Jika tidak ada kolom is_read, hitung semua notifikasi
        // $unreadCount = Notifikasi::where('role_id', 1)->count();

        return response()->json([
            'notifications' => $recentNotifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('notification_id');
        
        if ($notificationId) {
            Notifikasi::where('id', $notificationId)->update(['is_read' => true]);
        } else {
            Notifikasi::where('is_admin', 1)->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function markAsCompleted(Request $request, $id)
    {
        try {
            $notifikasi = Notifikasi::findOrFail($id);
            
            $notifikasi->update([
                'is_completed' => true,
                'completed_at' => now(),
                'is_read' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil ditandai sebagai selesai'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai notifikasi sebagai selesai'
            ], 500);
        }
    }

    public function markAsIncomplete(Request $request, $id)
    {
        try {
            $notifikasi = Notifikasi::findOrFail($id);
            
            $notifikasi->update([
                'is_completed' => false,
                'completed_at' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil ditandai sebagai belum selesai'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status notifikasi'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $notifikasi = Notifikasi::findOrFail($id);
            $notifikasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus notifikasi'
            ], 500);
        }
    }
}
