<?php

namespace App\Http\Controllers;

use App\Models\DP;
use Carbon\Carbon;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\Role;
use App\Models\DTPHP;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function kirimNotifikasi()
    {
        $periode = Carbon::now()->format('Y-m'); // contoh format periode: 2025-05
        $admin = Role::where('role', 'admin')->first();
        $roles = Role::where('role', '!=', 'admin')->get();

        foreach ($roles as $role) {
            // Cek apakah role sudah input data untuk periode ini
            $sudahInput = $this->cekInputData($role->role, $periode);

            // Notifikasi untuk role itu sendiri
            if (!$sudahInput) {
                Notifikasi::create([
                    'role_id' => $role->id,
                    'tanggal_pesan' => now(),
                    'pesan' => "{$role->role}, Dimohon segera menginputkan data untuk periode ini. Silakan lakukan peninjauan lebih lanjut."
                ]);
            }

            // Notifikasi untuk admin
            $pesanAdmin = $sudahInput
                ? "{$role->role}, Telah menginputkan data untuk periode ini. Silakan lakukan peninjauan lebih lanjut."
                : "{$role->role}, Belum menginputkan data untuk periode ini. Silakan lakukan peninjauan lebih lanjut.";

            Notifikasi::create([
                'role_id' => $admin->id,
                'tanggal_pesan' => now(),
                'pesan' => $pesanAdmin
            ]);
        }

        return response()->json(['message' => 'Notifikasi berhasil dikirim.']);
    }

    private function cekInputData(string $role, string $periode = null): bool
    {
        [$start, $end] = $this->getPeriodeRangeByRole($role);
    
        switch ($role) {
            case 'disperindag':
                return DB::table('dinas_perindustrian_perdagangan')
                    ->whereBetween('created_at', [$start, $end])
                    ->exists();
    
            case 'dkpp':
                return DB::table('dinas_ketahanan_pangan_peternakan')
                    ->whereBetween('created_at', [$start, $end])
                    ->exists();
    
            case 'dtphp':
                return DB::table('dinas_tanaman_pertanaian_holtikultural_perkebunan')
                    ->whereBetween('created_at', [$start, $end])
                    ->exists();
    
            case 'dp':
                return DB::table('dinas_perikanan')
                    ->whereBetween('created_at', [$start, $end])
                    ->exists();
    
            default:
                return false;
        }
    }

    public function tes()
    {
        $today = Carbon::now();

        $harian = DPP::whereDate('created_at', $today)->exists();
        
        $mingguan = DKPP::whereBetween('created_at', [
            $today->copy()->startOfWeek(Carbon::MONDAY),
            $today->copy()->endOfWeek(Carbon::SUNDAY)
        ])->exists();

        $bulanan = DP::whereBetween('created_at', [
            $today->copy()->startOfMonth(),
            $today->copy()->endOfMonth()
        ])->exists();

        $triwulan = DTPHP::whereBetween('created_at', [
            $today->copy()->startOfQuarter(),
            $today->copy()->endOfQuarter()
        ])->exists();

        return view('admin.test-notifikasi', [
            'harian' => $harian,
            'mingguan' => $mingguan,
            'bulanan' => $bulanan,
            'triwulan' => $triwulan,
        ]);
    }
}
