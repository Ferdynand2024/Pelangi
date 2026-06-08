<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_berhasil_sebagai_pembeli()
    {
        $user = User::factory()->create([
            'email' => 'azilaila0212@gmail.com',
            'password' => bcrypt('Lalabaik'),
            'role' => 'pembeli',
        ]);

        $response = $this->post('/login', [
            'email' => 'azilaila0212@gmail.com',
            'password' => 'Lalabaik',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_gagal_karena_password_salah()
    {
        User::factory()->create([
            'email' => 'azilaila0212@gmail.com',
            'password' => bcrypt('Lalabaik'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'azilaila0212@gmail.com',
            'password' => 'Lalabaip',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function login_gagal_karena_email_tidak_terdaftar()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'zizell02@gmail.com',
            'password' => 'Lalabaik',
        ]);

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test */
    public function login_gagal_karena_email_kosong()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'Lalabaik',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_gagal_karena_password_kosong()
    {
        $response = $this->post('/login', [
            'email' => 'azilaila0212@gmail.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function login_gagal_email_dan_password_kosong()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /** @test */
    public function login_gagal_format_email_tidak_valid()
    {
        $response = $this->post('/login', [
            'email' => 'rehan@gmail.com',
            'password' => 'Rehan1945',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function logout_berhasil_dari_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /** @test */
    public function login_berhasil_sebagai_admin()
    {
        $user = User::factory()->create([
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('adminbwi'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin1@gmail.com',
            'password' => 'adminbwi',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_berhasil_sebagai_tpi()
    {
        $user = User::factory()->create([
            'email' => 'tpimuncar1@gmail.com',
            'password' => bcrypt('tpimuncar01'),
            'role' => 'tpi',
        ]);

        $response = $this->post('/login', [
            'email' => 'tpimuncar1@gmail.com',
            'password' => 'tpimuncar01',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
