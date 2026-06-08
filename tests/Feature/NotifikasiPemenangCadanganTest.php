<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produk;
use App\Models\Penawaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NotifikasiPemenangCadanganTest extends TestCase
{
    use RefreshDatabase;

    /** @test TC01 */
    public function kirim_notifikasi_wa_ke_pemenang_cadangan_saat_pemenang_utama_gagal_membayar()
    {
        // 🧩 Setup: Buat produk lelang yang sudah selesai
        $produk = Produk::factory()->create([
            'jenis_ikan' => 'Tuna Sirip Kuning',
            'berat' => 50,
            'harga_awal' => 1000000,
            'status_lelang' => 'selesai',
        ]);

        // 🧩 Buat dua penawar (P1 = pemenang utama, P2 = pemenang cadangan)
        $pemenangUtama = User::factory()->create(['nama' => 'Penawar Utama']);
        $pemenangCadangan = User::factory()->create([
            'nama' => 'Penawar Cadangan',
            'no_wa' => '6281234567890',
        ]);

        $p1 = Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id' => $pemenangUtama->id,
            'jumlah_penawaran' => 1200000,
            'status' => 'gugur',
        ]);

        $p2 = Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id' => $pemenangCadangan->id,
            'jumlah_penawaran' => 1100000,
            'status' => 'belum',
        ]);

        // 🧠 Mocking API WhatsApp agar tidak benar-benar mengirim pesan
        Http::fake([
            'https://api.whatsapp.test/send' => Http::response(['status' => 'success'], 200),
        ]);

        // 🧪 Jalankan endpoint kirim notifikasi
        $response = $this->post('/lelang/kirim-notifikasi', [
            'produk_id' => $produk->id,
            'pemenang_id' => $pemenangCadangan->id,
        ]);

        // ✅ Verifikasi respons
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Notifikasi berhasil dikirim ke pemenang cadangan.',
        ]);

        // ✅ Pastikan request ke API WA dilakukan
        Http::assertSent(function ($request) use ($pemenangCadangan, $produk) {
            return $request->url() === 'https://api.whatsapp.test/send'
                && $request['to'] === $pemenangCadangan->no_wa
                && str_contains($request['message'], $produk->jenis_ikan)
                && str_contains($request['message'], (string) $produk->harga_awal);
        });
    }
}
