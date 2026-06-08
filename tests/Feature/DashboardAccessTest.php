<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class DashboardAccessTest extends TestCase
{
    // Menggunakan trait ini untuk mereset database setelah setiap pengujian
    use RefreshDatabase;

    /**
     * Data provider untuk peran pengguna yang seharusnya memiliki akses (Status 200).
     */
    public static function validRoleProvider(): array
    {
        return [
            // Peran | Role Value
            'Pembeli' => ['pembeli'],
            'Admin' => ['admin'],
            'TPI' => ['tpi'],
        ];
    }

    /**
     * Skenario 1 (Konsolidasi): Semua pengguna terautentikasi, terverifikasi, dan aktif (Pembeli, Admin, TPI)
     * dapat mengakses dashboard.
     */
    #[DataProvider('validRoleProvider')]
    public function test_semua_peran_valid_dapat_mengakses_dashboard(string $role): void
    {
        // 1. Arrange: Buat user yang valid dengan peran yang diberikan ($role).
        $user = User::factory()->create([
            'email_verified_at' => now(), // Memenuhi middleware 'verified'
            'role' => $role,             // Peran dari data provider
            'status' => 1,               // Status aktif
        ]);

        // 2. Act: Bertindak sebagai user dan akses route 'dashboard'
        $response = $this->actingAs($user)->get(route('dashboard'));

        // 3. Assert: Memastikan akses berhasil
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    // --- Skenario Kegagalan (Tetap Terpisah untuk Kejelasan Assert) ---

    /**
     * Skenario 2: Pengguna yang tidak terautentikasi (Guest) TIDAK dapat mengakses dashboard.
     * Pengujian middleware 'auth'.
     */
    public function test_guest_tidak_dapat_mengakses_dashboard(): void
    {
        // 1. Act: Akses route 'dashboard' tanpa login
        $response = $this->get(route('dashboard'));

        // 2. Assert: Memastikan diarahkan ke halaman login
        $response->assertRedirect('/login');
    }

    /**
     * Skenario 3: Pengguna terautentikasi tetapi BELUM terverifikasi TIDAK dapat mengakses dashboard.
     * Pengujian middleware 'verified'.
     */
    public function test_pengguna_belum_terverifikasi_tidak_dapat_mengakses_dashboard(): void
    {
        // 1. Arrange: Buat user 'pembeli' yang belum terverifikasi.
        $user = User::factory()->create([
            'email_verified_at' => null, // Belum terverifikasi
            'role' => 'pembeli',         
            'status' => 1,
        ]);

        // 2. Act: Bertindak sebagai user dan akses route 'dashboard'
        $response = $this->actingAs($user)->get(route('dashboard'));

        // 3. Assert: Memastikan diarahkan ke halaman verifikasi email
        $response->assertRedirect('verify-email');
    }

    /**
     * Skenario 4: Pengguna yang terautentikasi dan terverifikasi tetapi NON-AKTIF (status=0)
     * 
     *diizinkan mengakses dashboard. (Perlu middleware kustom untuk menolak akses jika status tidak aktif).
     */
    public function test_pengguna_nonaktif_dapat_mengakses_dashboard_tanpa_middleware_kustom(): void
    {
        // 1. Arrange: Buat user non-aktif yang terverifikasi.
        $userNonAktif = User::factory()->create([
            'email_verified_at' => now(), 
            'role' => 'pembeli',         
            'status' => 0, // Non-aktif
        ]);

        // 2. Act: Bertindak sebagai user non-aktif dan akses route 'dashboard'
        $response = $this->actingAs($userNonAktif)->get(route('dashboard'));
        

        // 3. Assert: Jika hanya 'auth' dan 'verified' yang digunakan, akses akan diizinkan (200).
        $response->assertStatus(403); 
    }
}
