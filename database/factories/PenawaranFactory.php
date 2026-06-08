<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenawaranFactory extends Factory
{
    public function definition(): array
    {
        return [
            'produk_id' => Produk::factory(),
            'user_id' => User::factory(),
            'jumlah_penawaran' => $this->faker->randomFloat(2, 10000, 50000),
            'status' => 'pending',
        ];
    }
}
