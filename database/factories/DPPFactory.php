<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DPP>
 */
class DPPFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'pasar' => $this->faker->randomElement(['Pasar A', 'Pasar B', 'Pasar C']),
            'jenis_bahan_pokok' => $this->faker->randomElement(['Beras', 'Gula', 'Minyak Goreng']),
            'kg_harga' => $this->faker->numberBetween(5000, 25000),
            'tanggal_dibuat' => $this->faker->date(),
        ];
    }
}
