<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangeEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test TC01 */
    public function mengubah_email_dengan_format_valid()
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin_' . uniqid() . '@gmail.com',
        ]);

        $newEmail = 'admin.new.' . uniqid() . '@gmail.com';

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'admin',
            'email' => $newEmail,
        ]);

        $response->assertSessionHas('status', 'profile-updated');
        $this->assertDatabaseHas('users', ['email' => $newEmail]);
    }

    /** @test TC02 */
    public function email_tidak_diubah()
    {
        $email = 'rehann_' . uniqid() . '@gmail.com';
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => $email,
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'admin',
            'email' => $email,
        ]);

        $response->assertSessionHas('status', 'profile-updated');
        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    /** @test TC03 */
    public function input_email_kosong()
    {
        $user = User::factory()->create([
            'email' => 'admin_' . uniqid() . '@gmail.com',
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'admin',
            'email' => '',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test TC04 */
    public function email_sudah_terdaftar_oleh_user_lain()
    {
        $existing = User::factory()->create(['email' => 'userlain_' . uniqid() . '@gmail.com']);
        $user = User::factory()->create(['email' => 'admin_' . uniqid() . '@gmail.com']);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'admin',
            'email' => $existing->email,
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    /** @test TC05 */
    public function email_huruf_besar_tetap_valid()
    {
        $user = User::factory()->create([
            'email' => 'admin_' . uniqid() . '@gmail.com',
        ]);

        $upperEmail = strtoupper('admin.new.' . uniqid() . '@gmail.com');

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'admin',
            'email' => $upperEmail,
        ]);

        $response->assertSessionHas('status', 'profile-updated');
        $this->assertDatabaseHas('users', [
            'email' => strtolower($upperEmail),
        ]);
    }
}
