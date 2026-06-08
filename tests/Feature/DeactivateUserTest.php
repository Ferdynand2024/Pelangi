<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeactivateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_berhasil_menonaktifkan_akun_user_aktif()
    {
        // Admin login
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 1,
        ]);

        // User yang akan dinonaktifkan
        $user = User::factory()->create([
            'role' => 'pembeli',
            'status' => 1, // aktif
        ]);

        $this->actingAs($admin)
            ->patch(route('tpi.toggle-status', $user->id))
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 0, // berhasil dinonaktifkan
        ]);
    }

    /** @test */
    public function user_gagal_login_setelah_dinonaktifkan()
    {
        // Buat user nonaktif
        $user = User::factory()->create([
            'email' => 'userb@gmail.com',
            'password' => Hash::make('password123'),
            'status' => 0, // nonaktif
            'role' => 'pembeli',
        ]);

        // Coba login
        $response = $this->post(route('login'), [
            'email' => 'userb@gmail.com',
            'password' => 'password123',
        ]);

        // Harus gagal login
        $response->assertSessionHasErrors([
            'status' => 'Akun Anda tidak aktif, silahkan hubungi admin.',
        ]);
    }
}
