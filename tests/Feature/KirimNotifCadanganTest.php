<?php

namespace Tests\Feature\Integrasi;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produk;
use App\Models\Penawaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class KirimNotifCadanganTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function kirim_notif_wa_ketika_pemenang_utama_gugur()
    {
        // Fake API WhatsApp (Fonnte)
        Http::fake([
            'https://api.fonnte.com/send' => Http::response(['status' => true], 200)
        ]);

        // --- Pre-State ---
        // Login TPI
        $tpi = User::factory()->create(['role' => 'tpi']);

        // Penawar utama & cadangan
        $penawar1 = User::factory()->create(['phone' => '081234567890']);   // gugur
        $penawar2 = User::factory()->create(['phone' => '081987654321']);   // naik jadi pemenang

        // Produk dilelang
        $produk = Produk::factory()->create([
            'deskripsi' => 'Ikan Tongkol Grade A',
        ]);

        // Penawaran utama (gugur)
        Penawaran::factory()->create([
            'produk_id'         => $produk->id,
            'user_id'           => $penawar1->id,
            'jumlah_penawaran'  => 500000,
            'status'            => 'gugur',
        ]);

        // Penawaran kedua (naik jadi pemenang)
        Penawaran::factory()->create([
            'produk_id'         => $produk->id,
            'user_id'           => $penawar2->id,
            'jumlah_penawaran'  => 450000,
            'status'            => 'menang',
        ]);

        // --- Eksekusi ---
        $this->actingAs($tpi);
        $response = $this->post(route('produk.kirimNotifCadangan', $produk->id));

        // --- Validasi ---
        $response->assertSessionHas('success');

        Http::assertSent(function ($request) use ($penawar2) {
            return
                $request->url() === 'https://api.fonnte.com/send' &&
                $request['target'] === '6281987654321';  // nomor diubah format internasional
        });
    }
}
