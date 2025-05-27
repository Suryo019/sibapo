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
            ['id' => 2, 'role' => 'disperindag'],
            ['id' => 3, 'role' => 'dkpp'],
            ['id' => 4, 'role' => 'dtphp'],
            ['id' => 5, 'role' => 'dp'],
            ['id' => 6, 'role' => 'pimpinan'],
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
            [
                'id' => 3,
                'name' => 'DKPP User',
                'role_id' => 3,
                'username' => 'dkppuser',
                'email' => 'dkpp@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => 4,
                'name' => 'DTPHP User',
                'role_id' => 4,
                'username' => 'dtphpuser',
                'email' => 'dtphp@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => 5,
                'name' => 'DP User',
                'role_id' => 5,
                'username' => 'dpuser',
                'email' => 'dp@example.com',
                'password' => Hash::make('password'),
            ],
        ]);

        $this->call(disperindagSeeder::class);

    }
}
