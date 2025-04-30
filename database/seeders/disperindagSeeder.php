<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\DPP;
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
    }
}
