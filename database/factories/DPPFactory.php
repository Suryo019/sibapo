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
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        return [
            'user_id' => 1,
            'pasar_id' => $this->faker->randomElement([1, 2, 3]),
            'jenis_bahan_pokok_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'kg_harga' => $this->faker->numberBetween(5000, 25000),
            'tanggal_dibuat' => $this->faker->dateTimeBetween($start, $end),
            'created_at' => $this->faker->dateTimeBetween($start, $end),
        ];
    }
}
