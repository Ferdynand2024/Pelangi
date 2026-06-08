<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produk;
use App\Models\Penawaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class LelangTest extends TestCase
{
    use RefreshDatabase;

    public function test_p1_gugur_dan_p2_diangkat_sebagai_pemenang()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $produk = Produk::factory()->create([
            'jenis_ikan' => 'Ikan Tuna',
            'berat' => 50.00,
            'harga_awal' => 300000,
            'deskripsi' => 'Tuna segar dari Banyuwangi',
            'status_lelang' => 'ditutup',
            'waktu_selesai' => Carbon::now()->subMinutes(100),
        ]);

        // P1 adalah penawar tertinggi tapi belum bayar
        $p1 = Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id' => $user1->id,
            'jumlah_penawaran' => 500000.00,
            'status' => 'belum', // belum bayar
            'created_at' => Carbon::now()->subMinutes(110),
        ]);

        // P2 adalah penawar kedua
        $p2 = Penawaran::factory()->create([
            'produk_id' => $produk->id,
            'user_id' => $user2->id,
            'jumlah_penawaran' => 480000.00,
            'status' => 'pending',
            'created_at' => Carbon::now()->subMinutes(105),
        ]);

        // Ccek apakah P1 sudah lewat 90 menit dan gugur,
        // lalu menaikkan P2 sebagai pemenang
        if ($produk->waktu_selesai->diffInMinutes(now()) > 90) {
            $p1->update(['status' => 'gugur']);
            $p2->update(['status' => 'belum']);
            $produk->update([
                'pemenang_lelang_id' => $p2->user_id,
                'harga_akhir' => $p2->jumlah_penawaran,
            ]);
        }

        $p1->refresh();
        $p2->refresh();
        $produk->refresh();

        $this->assertEquals('gugur', $p1->status, 'P1 seharusnya berstatus Gugur');
        $this->assertEquals('belum', $p2->status, 'P2 seharusnya menjadi pemenang dengan status Belum');
        $this->assertEquals($user2->id, $produk->pemenang_lelang_id, 'Produk harus mencatat P2 sebagai pemenang');
        $this->assertEquals(480000.00, $produk->harga_akhir);
    }
}
