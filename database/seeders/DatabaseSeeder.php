<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'role' => 'admin'],
            ['id' => 2, 'role' => 'dpp'],
            ['id' => 3, 'role' => 'dkpp'],
            ['id' => 4, 'role' => 'dtphp'],
            ['id' => 5, 'role' => 'dp'],
        ]);

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin User',
                'role_id' => 1,
                'username' => 'adminuser',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => 2,
                'name' => 'DPP User',
                'role_id' => 2,
                'username' => 'dppuser',
                'email' => 'dpp@example.com',
                'password' => Hash::make('password'),
            ],
        ]);

        $this->call(disperindagSeeder::class);

    }
}
