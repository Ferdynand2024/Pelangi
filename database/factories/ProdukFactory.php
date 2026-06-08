<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    public function definition(): array
    {
        return [
            'foto' => null,
            'jenis_ikan' => $this->faker->word(),
            'berat' => $this->faker->randomFloat(2, 1, 10),
            'harga_awal' => $this->faker->randomFloat(2, 10000, 100000),
            'deskripsi' => $this->faker->sentence(),
            'status_lelang' => 'belum_dimulai',
            'waktu_mulai' => now(),
            'waktu_selesai' => now()->addHours(2),
            'pemenang_lelang_id' => null,
            'harga_akhir' => null,
        ];
    }
}
