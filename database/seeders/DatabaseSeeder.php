<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '111111111',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'TPI Muncar',
            'email' => 'tpi@gmail.com',
            'password' => '111111111',
            'role' => 'tpi'
        ]);

        User::factory()->create([
            'name' => 'Ferdynand',
            'email' => 'Ferdynand@gmail.com',
            'password' => '111111111',
            'role' => 'pembeli'
        ]);

        User::factory()->create([
            'name' => 'Septa',
            'email' => 'Septa@gmail.com',
            'password' => '111111111',
            'role' => 'pembeli'
        ]);

        User::factory()->create([
            'name' => 'Rehan',
            'email' => 'Rehan@gmail.com',
            'password' => '111111111',
            'role' => 'pembeli'
        ]);
        
    }
}
