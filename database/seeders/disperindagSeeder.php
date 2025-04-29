<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class disperindagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasarList = ['Pasar Tanjung', 'Pasar Krempyeng', 'Pasar Pontang', 'Pasar Ambulu'];
        $bahanPokokList = [
            'Beras', 'Gula', 'Minyak Goreng', 'Tepung Terigu', 'Telur Ayam',
            'Daging Ayam', 'Daging Sapi', 'Cabe Merah', 'Cabe Rawit',
            'Bawang Merah', 'Bawang Putih', 'Ikan Segar', 'Sayur Mayur'
        ];

        $tanggalAwal = Carbon::create(2025, 5, 1);
        $tanggalAkhir = Carbon::create(2025, 5, 30);

        foreach (range(1, 100) as $i) {
            DB::table('dinas_perindustrian_perdagangan')->insert([
                'user_id' => rand(1, 2),
                'pasar' => $pasarList[array_rand($pasarList)],
                'jenis_bahan_pokok' => $bahanPokokList[array_rand($bahanPokokList)],
                'kg_harga' => rand(5000, 30000),
                'tanggal_dibuat' => $tanggalAwal->copy()->addDays(rand(0, $tanggalAkhir->diffInDays($tanggalAwal))),
            ]);
        }
    }
}
