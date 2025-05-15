<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\DPP;
use App\Models\Riwayat;
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
        DPP::factory()->count(10)->create();
        Riwayat::factory()->count(10)->create();

        DB::table('pasar')->insert([
            ['id' => 1, 'nama_pasar' => 'Pasar Tanjung'],
            ['id' => 2, 'nama_pasar' => 'Pasar Kreongan'],
            ['id' => 3, 'nama_pasar' => 'Pasar Mangli'],
        ]);

        DB::table('jenis_bahan_pokok')->insert([
            ['id' => 1, 'nama_bahan_pokok' => 'Daging Sapi IIX'],
            ['id' => 2, 'nama_bahan_pokok' => 'Ayam Kampung'],
            ['id' => 3, 'nama_bahan_pokok' => 'Tomat Ceri'],
            ['id' => 4, 'nama_bahan_pokok' => 'Bawang Merah'],
            ['id' => 5, 'nama_bahan_pokok' => 'Bawang Putih'],
            ['id' => 6, 'nama_bahan_pokok' => 'Cabai Merah'],
            ['id' => 7, 'nama_bahan_pokok' => 'Cabai Rawit'],
            ['id' => 8, 'nama_bahan_pokok' => 'Minyak Goreng'],
            ['id' => 9, 'nama_bahan_pokok' => 'Telur Ayam'],
            ['id' => 10, 'nama_bahan_pokok' => 'Beras Medium'],
        ]);
    }
}
