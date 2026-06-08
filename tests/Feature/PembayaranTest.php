<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produk;
use App\Models\Penawaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Midtrans\Snap;
use Mockery;

class PembayaranTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pemenang_bisa_membuka_halaman_pembayaran()
    {
        // Mock Token Midtrans
        Mockery::mock('alias:Midtrans\Snap')
            ->shouldReceive('getSnapToken')
            ->andReturn('SNAP_TEST_TOKEN');


        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $produk = Produk::factory()->create([
            'waktu_selesai' => Carbon::now(),
        ]);

        $penawaran = Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id'   => $pembeli->id,
            'jumlah_penawaran' => 500000,
            'status' => 'belum'
        ]);

        $this->actingAs($pembeli);

        $response = $this->get(
            route('lelang.pembayaran', $produk->id)
        );

        $response->assertStatus(200);
        $response->assertViewIs('pembeli.pembayaran');
        $response->assertViewHas('snapToken');
    }

    /** @test */
    public function user_bukan_pemenang_dilarang_akses_pembayaran()
    {
        $pembeli1 = User::factory()->create(['role' => 'pembeli']);
        $pembeli2 = User::factory()->create(['role' => 'pembeli']);

        $produk = Produk::factory()->create([
            'waktu_selesai' => Carbon::now(),
        ]);

        // Pemenang asli
        Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id'   => $pembeli1->id,
            'jumlah_penawaran' => 600000,
            'status' => 'belum',
        ]);

        $this->actingAs($pembeli2);

        $response = $this->get(
            route('lelang.pembayaran', $produk->id)
        );

        $response->assertStatus(403);
    }


    /** @test */
    public function pembayaran_berhasil_menyimpan_status_pemenang()
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $produk = Produk::factory()->create([
            'waktu_selesai' => Carbon::now(),
        ]);

        $penawaran = Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id'   => $pembeli->id,
            'jumlah_penawaran' => 700000,
            'status' => 'belum'
        ]);

        $this->actingAs($pembeli);

        $response = $this->get(
            route('pembayaran.konfirmasi', $produk->id)
        );

        $response->assertRedirect(
            route('lelang.bukti-pembayaran', $produk->id)
        );

        $this->assertDatabaseHas('penawarans', [
            'id' => $penawaran->id,
            'status' => 'sudah'
        ]);
    }


    /** @test */
    public function pemenang_yang_sudah_bayar_bisa_melihat_bukti_pembayaran()
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);

        $produk = Produk::factory()->create([
            'waktu_selesai' => Carbon::now(),
        ]);

        Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id'   => $pembeli->id,
            'jumlah_penawaran' => 900000,
            'status' => 'sudah'
        ]);

        $this->actingAs($pembeli);

        $response = $this->get(
            route('lelang.bukti-pembayaran', $produk->id)
        );

        $response->assertStatus(200);
        $response->assertViewIs('pembeli.bukti-pembayaran');
    }


    /** @test */
    public function user_yang_belum_bayar_tidak_boleh_melihat_bukti_pembayaran()
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);

        $produk = Produk::factory()->create([
            'waktu_selesai' => Carbon::now(),
        ]);

        // Dia pemenang tapi belum bayar
        Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id'   => $pembeli->id,
            'jumlah_penawaran' => 800000,
            'status' => 'belum'
        ]);

        $this->actingAs($pembeli);

        $response = $this->get(
            route('lelang.bukti-pembayaran', $produk->id)
        );

        $response->assertStatus(403);
    }
}
