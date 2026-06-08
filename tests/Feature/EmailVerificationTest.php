<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC01 - Kirim link verifikasi dengan email terdaftar (user login & belum terverifikasi)
     */
    public function test_kirim_link_verifikasi_dengan_email_terdaftar()
    {
        // 1️⃣ Fake notification agar email tidak benar-benar dikirim
        Notification::fake();

        // 2️⃣ Buat user valid tapi belum diverifikasi
        $user = User::factory()->create([
            'email' => 'tpimuncar@gmail.com',
            'email_verified_at' => null,
            'status' => 1,
        ]);

        // 3️⃣ Bertindak sebagai user login
        $response = $this->actingAs($user)->post('/email/verification-notification');

        // 4️⃣ Pastikan notifikasi terkirim
        Notification::assertSentTo($user, VerifyEmail::class);

        // 5️⃣ Pastikan redirect dan pesan status sesuai
        $response->assertRedirect();
        $response->assertSessionHas('status', 'verification-link-sent');
    }

    /**
     * TC02 - Gagal kirim link verifikasi karena email tidak terdaftar (belum login)
     */
    public function test_gagal_kirim_link_verifikasi_email_tidak_terdaftar()
    {
        Notification::fake();

        // Tidak ada user login (guest)
        $response = $this->post('/email/verification-notification');

        // Karena route dilindungi middleware auth, guest akan diarahkan ke login
        $response->assertRedirect('/login');

        // Pastikan tidak ada notifikasi dikirim
        Notification::assertNothingSent();
    }
}

