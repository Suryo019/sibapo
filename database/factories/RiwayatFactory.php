<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Riwayat>
 */
class RiwayatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 2,
            'komoditas' => $this->faker->randomElement(
                ['Daging Sapi IIX'],
                ['Ayam Kampung'],
                ['Tomat Ceri'],
                ['Bawang Merah'],
                ['Bawang Putih'],
                ['Cabai Merah'],
                ['Cabai Rawit'],
                ['Minyak Goreng'],
                ['Telur Ayam'],
                ['Beras Medium'],
            ),
            'aksi' => 'buat',
        ];
    }
}
