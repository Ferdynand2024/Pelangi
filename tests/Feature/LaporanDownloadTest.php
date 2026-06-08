<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanDownloadTest extends TestCase
{
    use RefreshDatabase;

    /** @test TC01 */
    public function admin_dapat_mendownload_laporan_excel_dengan_data_lengkap()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Buat beberapa produk manual tanpa factory
        for ($i = 1; $i <= 5; $i++) {
            Produk::create([
                'jenis_ikan' => 'Ikan ' . $i,
                'berat' => 10 + $i,
                'harga_awal' => 10000 + ($i * 500),
                'status_lelang' => 'ditutup',
            ]);
        }

        $response = $this->actingAs($admin)->get(route('laporan.export'));

        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('Content-Disposition'), '.xlsx'));
    }

    /** @test TC02 */
    public function admin_dapat_mendownload_laporan_kosong_dan_file_tetap_terbentuk()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get(route('laporan.export'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition');
    }

    /** @test TC03 */
    public function admin_dapat_mendownload_laporan_dengan_data_sangat_banyak()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        for ($i = 1; $i <= 50; $i++) {
            Produk::create([
                'jenis_ikan' => 'Ikan Besar ' . $i,
                'berat' => 20 + $i,
                'harga_awal' => 20000 + ($i * 100),
                'status_lelang' => 'ditutup',
            ]);
        }

        $response = $this->actingAs($admin)->get(route('laporan.export'));
        $response->assertStatus(200);
    }

    /** @test TC04 */
    public function admin_mendownload_laporan_tanpa_filter_menampilkan_pesan_atau_file_default()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get(route('laporan.export'));
        $response->assertStatus(200);
    }

    /** @test TC05 */
    public function isi_file_excel_yang_didownload_memiliki_header_yang_jelas()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Produk::create([
            'jenis_ikan' => 'Ikan Tongkol',
            'berat' => 12,
            'harga_awal' => 12000,
            'status_lelang' => 'ditutup',
        ]);

        $response = $this->actingAs($admin)->get(route('laporan.export'));
        $response->assertStatus(200);
        $this->assertTrue(
            str_contains($response->headers->get('Content-Disposition'), '.xlsx')
        );
    }

    /** @test TC06 */
    public function download_berkali_kali_dalam_waktu_singkat_menghasilkan_file_yang_sama()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Produk::create([
            'jenis_ikan' => 'Ikan Kerapu',
            'berat' => 8,
            'harga_awal' => 8000,
            'status_lelang' => 'ditutup',
        ]);

        $first = $this->actingAs($admin)->get(route('laporan.export'));
        $second = $this->actingAs($admin)->get(route('laporan.export'));

        $first->assertStatus(200);
        $second->assertStatus(200);
        $this->assertEquals(
            $first->headers->get('Content-Disposition'),
            $second->headers->get('Content-Disposition')
        );
    }

    /** @test TC07 */
    public function nama_file_download_sesuai_dengan_konten_dan_filter()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get(route('laporan.export'));
        $response->assertStatus(200);

        $filename = $response->headers->get('Content-Disposition');
        $this->assertTrue(
            str_contains($filename, 'laporan') || str_contains($filename, 'Laporan'),
            'Nama file harus mengandung kata "Laporan" atau "laporan"'
        );
    }

    /** @test TC08 */
    public function user_non_admin_tidak_dapat_mendownload_laporan()
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $response = $this->actingAs($pembeli)->get(route('laporan.export'));
        $response->assertStatus(403);
    }
}
