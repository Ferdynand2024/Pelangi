<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produk;
use App\Models\Penawaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenawaranTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $produk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->produk = Produk::factory()->create([
            'harga_awal' => 100000,
            'status_lelang' => 'dibuka',
            'waktu_mulai' => now()->subHour(),
            'waktu_selesai' => now()->addHour(),
        ]);

        $this->actingAs($this->user);
    }

    public function test_penawaran_lebih_tinggi_diterima()
    {
        $response = $this->post(route('penawaran.store', $this->produk->id), [
            'jumlah_penawaran' => 105000,
        ]);

        $response->assertSessionHas('success');
    }

    public function test_penawaran_sama_ditolak()
    {

        $response = $this->post(route('penawaran.store', $this->produk->id), [
            'jumlah_penawaran' => 100000,
        ]);

        $response->assertSessionHas('error');
    }

    public function test_penawaran_lebih_rendah_ditolak()
    {
        $response = $this->post(route('penawaran.store', $this->produk->id), [
            'jumlah_penawaran' => 95000,
        ]);

        $response->assertSessionHas('error');
    }

    public function test_penawaran_kosong_ditolak()
    {
        $response = $this->post(route('penawaran.store', $this->produk->id), [
            'jumlah_penawaran' => '',
        ]);

        $response->assertSessionHasErrors('jumlah_penawaran');
    }

    public function test_penawaran_non_numerik_ditolak()
    {
        $response = $this->post(route('penawaran.store', $this->produk->id), [
            'jumlah_penawaran' => 'abc',
        ]);

        $response->assertSessionHasErrors('jumlah_penawaran');
    }

    public function test_user_sama_bisa_menawar_lagi_dengan_harga_lebih_tinggi()
    {
        Penawaran::factory()->create([
            'produk_id' => $this->produk->id,
            'user_id' => $this->user->id,
            'jumlah_penawaran' => 100000,
        ]);

        $response = $this->post(route('penawaran.store', $this->produk->id), [
            'jumlah_penawaran' => 110000,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('penawarans', [
            'jumlah_penawaran' => 110000,
        ]);
    }

    public function test_penawaran_dengan_format_desimal()
    {
        $response = $this->post(route('penawaran.store', $this->produk->id), [
            'jumlah_penawaran' => 100000.50,
        ]);

        $response->assertSessionHasErrors('jumlah_penawaran');
    }

    public function test_penawaran_harga_sangat_besar()
    {
        $response = $this->post(route('penawaran.store', $this->produk->id), [
            'jumlah_penawaran' => 9999999999,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('penawarans', [
            'jumlah_penawaran' => 9999999999,
        ]);
    }
}
