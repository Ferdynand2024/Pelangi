<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TpiRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function admin()
    {
        return User::factory()->create([
            'role' => 'admin'
        ]);
    }

    /** @test */
    public function admin_dapat_menambah_tpi()
    {
        $this->actingAs($this->admin());

        $response = $this->post(route('tpi.store'), [
            'name' => 'TPI Baru',
            'email' => 'tpi@example.com',
            'phone' => '08123456789',
            'alamat' => 'Jalan Laut',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('tpi.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'tpi@example.com',
            'role' => 'tpi',
        ]);
    }

    /** @test */
    public function validasi_gagal_jika_name_kosong()
    {
        $this->actingAs($this->admin());

        $response = $this->post(route('tpi.store'), [
            'name' => '',
            'email' => 'tpi@example.com',
            'phone' => '08123456789',
            'alamat' => 'Alamat',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function validasi_gagal_jika_email_tidak_valid()
    {
        $this->actingAs($this->admin());

        $response = $this->post(route('tpi.store'), [
            'name' => 'TPI Baru',
            'email' => 'bukan-email',
            'phone' => '08123456789',
            'alamat' => 'Alamat',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function validasi_gagal_jika_email_sudah_digunakan()
    {
        $this->actingAs($this->admin());

        User::factory()->create([
            'email' => 'tpi@example.com'
        ]);

        $response = $this->post(route('tpi.store'), [
            'name' => 'TPI Baru',
            'email' => 'tpi@example.com', // duplicate
            'phone' => '08123456789',
            'alamat' => 'Alamat',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function validasi_gagal_jika_password_kurang_dari_8()
    {
        $this->actingAs($this->admin());

        $response = $this->post(route('tpi.store'), [
            'name' => 'TPI Baru',
            'email' => 'tpi@example.com',
            'phone' => '08123456789',
            'alamat' => 'Alamat',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function admin_dapat_mengupdate_tpi()
    {
        $this->actingAs($this->admin());

        $user = User::factory()->create([
            'role' => 'tpi'
        ]);

        $response = $this->put(route('tpi.update', $user->id), [
            'name' => 'Updated Nama',
            'email' => 'baru@example.com',
            'phone' => '08123456789',
            'alamat' => 'Alamat Baru',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('tpi.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Nama',
            'email' => 'baru@example.com',
        ]);
    }

    /** @test */
    public function admin_dapat_mengubah_status_tpi()
    {
        $this->actingAs($this->admin());

        $user = User::factory()->create([
            'role' => 'tpi',
            'status' => true,
        ]);

        $response = $this->patch(route('tpi.toggle-status', $user->id));

        $response->assertRedirect(route('tpi.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => false,
        ]);
    }

    /** @test */
    public function halaman_edit_tpi_bisa_diakses_admin()
    {
        $this->actingAs($this->admin());

        $user = User::factory()->create(['role' => 'tpi']);

        $response = $this->get(route('tpi.edit', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('tpi.edit');
    }
}
