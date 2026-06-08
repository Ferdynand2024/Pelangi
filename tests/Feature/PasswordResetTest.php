<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC01 — Kirim link reset password berhasil dengan email terdaftar
     */
    public function test_kirim_link_reset_password_berhasil_dengan_email_terdaftar()
    {
        // 1️⃣ Fake notifikasi agar email tidak benar-benar dikirim
        Notification::fake();

        // 2️⃣ Buat user terdaftar
        $user = User::factory()->create([
            'email' => 'tpimuncar@gmail.com',
            'email_verified_at' => now(),
        ]);

        // 3️⃣ Kirim request ke route lupa password
        $response = $this->post('/forgot-password', [
            'email' => 'tpimuncar@gmail.com',
        ]);

        // 4️⃣ Pastikan redirect dan pesan status muncul
        $response->assertSessionHas('status', 'We have emailed your password reset link.');

        // 5️⃣ Pastikan notifikasi ResetPassword dikirim ke user
        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * TC02 — Gagal kirim link reset password karena email tidak terdaftar
     */
    public function test_gagal_kirim_link_reset_password_email_tidak_terdaftar()
    {
        Notification::fake();

        // Kirim request dengan email yang tidak ada
        $response = $this->from('/forgot-password')->post('/forgot-password', [
            'email' => 'tidakada@gmail.com',
        ]);

        // Laravel default: tetap redirect, tapi tanpa status success
        $response->assertSessionHasErrors(['email']);

        // Pastikan tidak ada notifikasi dikirim
        Notification::assertNothingSent();
    }

    /**
     * TC03 — Gagal kirim link reset password karena kolom email kosong
     */
    public function test_gagal_kirim_link_reset_password_email_kosong()
    {
        $response = $this->from('/forgot-password')->post('/forgot-password', [
            'email' => '',
        ]);

        // Validasi bawaan Laravel menolak input kosong
        $response->assertSessionHasErrors(['email' => 'The email field is required.']);
    }

    /**
     * TC04 — Gagal kirim link reset password karena format email tidak valid
     */
    public function test_gagal_kirim_link_reset_password_format_email_tidak_valid()
    {
        $response = $this->from('/forgot-password')->post('/forgot-password', [
            'email' => 'tpimuncar.gmail.com',
        ]);

        // Validasi Laravel menolak format email salah
        $response->assertSessionHasErrors(['email' => 'The email field must be a valid email address.']);
    }
}
