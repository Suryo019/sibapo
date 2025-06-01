<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Notifikasi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateNotifikasi extends Command
{
    protected $signature = 'notifikasi:generate {role_id}';
    protected $description = 'Generate notifikasi untuk role tertentu berdasarkan pengisian data';

    private array $map = [
        2 => ['table' => 'dinas_perindustrian_perdagangan',              'date' => 'created_at'],
        3 => ['table' => 'dinas_ketahanan_pangan_peternakan',            'date' => 'created_at'],
        4 => ['table' => 'dinas_tanaman_pangan_holtikultural_perkebunan','date' => 'created_at'],
        5 => ['table' => 'dinas_perikanan',                              'date' => 'created_at'],
    ];

    public function handle(): int
    {
        $roleId   = (int)$this->argument('role_id');
        $roleName = Role::find($roleId)?->role ?? 'Tidak Dikenal';
        $now      = Carbon::now();
        $month    = $now->month;
        $year     = $now->year;
        $deadline = now()->subDay();
        $adminId  = 1;

        if (!isset($this->map[$roleId])) {
            $this->warn("Role ID $roleId tidak dikenali.");
            return self::FAILURE;
        }

        $cfg = $this->map[$roleId];

        $sudahInput = DB::table($cfg['table'].' as t')
            ->join('users as u', 'u.id', '=', 't.user_id')
            ->where('u.role_id', $roleId)
            ->whereMonth("t.{$cfg['date']}", $month)
            ->whereYear("t.{$cfg['date']}",  $year)
            ->exists();

        Notifikasi::create([
            'role_id'       => $adminId,
            'tanggal_pesan' => $now,
            'pesan'         => $sudahInput
                ? "{$roleName} telah menginputkan data untuk periode ini."
                : "{$roleName} belum menginputkan data untuk periode ini.",
        ]);

        if (!$sudahInput && $now->greaterThanOrEqualTo($deadline)) {
            Notifikasi::create([
                'role_id'       => $roleId,
                'tanggal_pesan' => $now,
                'pesan'         => "{$roleName} segera menginputkan data untuk periode ini. Silakan lakukan peninjauan lebih lanjut.",
            ]);
        }

        $this->info("Notifikasi untuk role {$roleName} berhasil dikirim.");
        return self::SUCCESS;
    }
}
