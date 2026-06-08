<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PembeliRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** TC - REG - 01 */
    public function test_registrasi_berhasil_dengan_data_valid()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan123#',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'rehan@gmail.com']);
    }

    /** TC - REG - 02 */
    public function test_registrasi_gagal_email_sudah_terdaftar()
    {
        User::factory()->create(['email' => 'rehan.dev@gmail.com']);

        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan.dev@gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan123#',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** TC - REG - 03 */
    public function test_registrasi_gagal_format_email_salah()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan.gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan123#',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** TC - REG - 04 */
    public function test_registrasi_gagal_nama_tidak_diisi()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'rehan@gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan123#',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** TC - REG - 05 */
    public function test_registrasi_gagal_email_tidak_diisi()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => '',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan123#',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** TC - REG - 06 */
    public function test_registrasi_gagal_nomor_telp_tidak_diisi()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan123#',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** TC - REG - 07 */
    public function test_registrasi_gagal_alamat_tidak_diisi()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '081234567890',
            'alamat' => '',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan123#',
        ]);

        $response->assertSessionHasErrors(['alamat']);
    }

    /** TC - REG - 08 */
    public function test_registrasi_gagal_password_kurang_dari_8_karakter()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Reha1#',
            'password_confirmation' => 'Reha1#',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** TC - REG - 09 */
    public function test_registrasi_gagal_tidak_ada_huruf_kapital()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'rehan123#',
            'password_confirmation' => 'rehan123#',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** TC - REG - 10 */
    public function test_registrasi_gagal_tidak_ada_angka()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan#',
            'password_confirmation' => 'Rehan#',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** TC - REG - 11 */
    public function test_registrasi_gagal_tidak_ada_simbol()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123',
            'password_confirmation' => 'Rehan123',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** TC - REG - 12 */
    public function test_registrasi_gagal_konfirmasi_password_tidak_sama()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan456#',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** TC - REG - 13 */
    public function test_registrasi_gagal_nomor_telp_mengandung_huruf()
    {
        $response = $this->post('/register', [
            'name' => 'Rehan',
            'email' => 'rehan@gmail.com',
            'phone' => '08123O56789',
            'alamat' => 'Jl. Pelabuhan Muncar No. 1',
            'password' => 'Rehan123#',
            'password_confirmation' => 'Rehan123#',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }
}
