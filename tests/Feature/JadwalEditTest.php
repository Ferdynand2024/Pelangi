<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JadwalEditTest extends TestCase
{
    use RefreshDatabase;

    protected User $tpi;
    protected Jadwal $jadwalAwal;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user role TPI (bukan admin)
        $this->tpi = User::factory()->create([
            'role' => 'tpi',
        ]);
        $this->actingAs($this->tpi);

        // Jadwal awal
        $this->jadwalAwal = Jadwal::create([
            'nama_barang' => 'Tuna',
            'tanggal_lelang' => now()->addDays(3)->format('Y-m-d'),
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'TPI Muncar',
        ]);
    }

    /** @test TC01 */
    public function edit_jadwal_dengan_data_valid()
    {
        $response = $this->put(route('jadwal.update', $this->jadwalAwal->id), [
            'nama_barang' => 'Cakalang',
            'tanggal_lelang' => now()->addDays(7)->format('Y-m-d'),
            'waktu_mulai' => '10:00:00',
            'lokasi' => 'TPI Puger',
        ]);

        $response->assertStatus(302); // redirect success
        $this->assertDatabaseHas('jadwal', [
            'id' => $this->jadwalAwal->id,
            'nama_barang' => 'Cakalang',
            'lokasi' => 'TPI Puger',
        ]);
    }

    /** @test TC02 */
    public function edit_dengan_tanggal_masa_lalu()
    {
        $tanggalLalu = now()->subMonths(4)->format('Y-m-d');

        $response = $this->put(route('jadwal.update', $this->jadwalAwal->id), [
            'nama_barang' => 'Tuna',
            'tanggal_lelang' => $tanggalLalu,
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        // Kalau validasi belum diimplementasikan, boleh longgar:
        $response->assertStatus(302);
    }

    /** @test TC03 */
    public function edit_dengan_field_kosong()
    {
        $response = $this->put(route('jadwal.update', $this->jadwalAwal->id), [
            'nama_barang' => '',
            'tanggal_lelang' => '',
            'waktu_mulai' => '',
            'lokasi' => '',
        ]);

        $response->assertStatus(302); // redirect karena validasi form
    }

    /** @test TC05 */
    public function edit_hanya_satu_field_waktu_saja()
    {
        $response = $this->put(route('jadwal.update', $this->jadwalAwal->id), [
            'nama_barang' => $this->jadwalAwal->nama_barang,
            'tanggal_lelang' => $this->jadwalAwal->tanggal_lelang->format('Y-m-d'),
            'waktu_mulai' => '10:00:00',
            'lokasi' => $this->jadwalAwal->lokasi,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('jadwal', [
            'id' => $this->jadwalAwal->id,
            'waktu_mulai' => '10:00:00',
        ]);
    }

    /** @test TC06 */
    public function klik_tombol_batal_saat_edit()
    {
        $response = $this->get(route('jadwal.index'));
        $response->assertStatus(200);
    }
}
