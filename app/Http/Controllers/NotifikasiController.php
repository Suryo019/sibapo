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
        $today = Carbon::now();
        $admin = Role::where('role', 'admin')->first();
    
        $roles = Role::where('role', '!=', 'admin')->get();
    
        foreach ($roles as $role) {
            $roleName = $role->role;
            $periode = $this->getPeriodeRangeByRole($roleName);
    
            $sudahInput = DB::table($this->getTableByRole($roleName))
                ->whereBetween('created_at', $periode)
                ->exists();
    
            // Kirim notifikasi ke dinas bersangkutan
            if (!$sudahInput) {
                Notifikasi::create([
                    'role_id' => $role->id,
                    'tanggal_pesan' => now(),
                    'pesan' => strtoupper($roleName) . " belum menginputkan data untuk periode ini. Silakan lakukan peninjauan lebih lanjut."
                ]);
            }
    
            // Kirim notifikasi ke admin
            $pesanAdmin = $sudahInput
                ? strtoupper($roleName) . " telah menginputkan data untuk periode ini."
                : strtoupper($roleName) . " belum menginputkan data untuk periode ini.";
    
            Notifikasi::create([
                'role_id' => $admin->id,
                'tanggal_pesan' => now(),
                'pesan' => $pesanAdmin
            ]);
        }
    
        return response()->json(['message' => 'Notifikasi berhasil dikirim.']);
    }
    
    private function getPeriodeRangeByRole(string $role): array
    {
        $today = Carbon::now();
    
        return match ($role) {
            'disperindag' => [$today->copy()->startOfDay(), $today->copy()->endOfDay()], // harian
            'dkpp' => [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()], // mingguan
            'dtphp' => [$today->copy()->startOfQuarter(), $today->copy()->endOfQuarter()], // triwulan
            'perikanan' => [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()], // bulanan
            default => [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()],
        };
    }
    
    private function getTableByRole(string $role): string
    {
        return match ($role) {
            'disperindag' => 'dinas_perindustrian_perdagangan',
            'dkpp' => 'dinas_ketahanan_pangan_peternakan',
            'dtphp' => 'dinas_tanaman_pertanaian_holtikultural_perkebunan',
            'dp' => 'dinas_perikanan',
            default => 'unknown',
        };
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
