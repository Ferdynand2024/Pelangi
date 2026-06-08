<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JadwalLelangTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function tambah_jadwal_dengan_data_valid()
    {
        $tpi = User::factory()->create(['role' => 'tpi']);
        $this->actingAs($tpi);

        $tanggal = now()->addDays(5)->format('Y-m-d');

        $response = $this->post(route('jadwal.store'), [
            'nama_barang' => 'Tuna',
            'tanggal_lelang' => $tanggal,
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        $response->assertRedirect(route('jadwal.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('jadwal', ['nama_barang' => 'Tuna']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function tambah_jadwal_dengan_tanggal_masa_lalu()
    {
        $tpi = User::factory()->create(['role' => 'tpi']);
        $this->actingAs($tpi);

        $tanggal = now()->subDays(5)->format('Y-m-d');

        $response = $this->post(route('jadwal.store'), [
            'nama_barang' => 'Tuna',
            'tanggal_lelang' => $tanggal,
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        $response->assertSessionHasErrors('tanggal_lelang');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function tambah_jadwal_dengan_field_kosong()
    {
        $tpi = User::factory()->create(['role' => 'tpi']);
        $this->actingAs($tpi);

        $response = $this->post(route('jadwal.store'), [
            'nama_barang' => '',
            'tanggal_lelang' => '',
            'waktu_mulai' => '',
            'lokasi' => '',
        ]);

        $response->assertSessionHasErrors(['nama_barang', 'tanggal_lelang', 'waktu_mulai', 'lokasi']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function jadwal_bentrok_tetap_bisa_dibuat()
    {
        $tpi = User::factory()->create(['role' => 'tpi']);
        $this->actingAs($tpi);

        Jadwal::create([
            'nama_barang' => 'Tuna',
            'tanggal_lelang' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        $response = $this->post(route('jadwal.store'), [
            'nama_barang' => 'Tuna Baru',
            'tanggal_lelang' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        $response->assertRedirect(route('jadwal.index'));
        $this->assertDatabaseHas('jadwal', ['nama_barang' => 'Tuna Baru']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function edit_jadwal_berhasil()
    {
        $tpi = User::factory()->create(['role' => 'tpi']);
        $this->actingAs($tpi);

        $jadwal = Jadwal::create([
            'nama_barang' => 'Tuna',
            'tanggal_lelang' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        $response = $this->put(route('jadwal.update', $jadwal->id), [
            'nama_barang' => 'Tuna Besar',
            'tanggal_lelang' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '10:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        $response->assertRedirect(route('jadwal.index'));
        $this->assertDatabaseHas('jadwal', ['nama_barang' => 'Tuna Besar']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function hapus_jadwal_berhasil()
    {
        $tpi = User::factory()->create(['role' => 'tpi']);
        $this->actingAs($tpi);

        $jadwal = Jadwal::create([
            'nama_barang' => 'Tuna',
            'tanggal_lelang' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        $response = $this->delete(route('jadwal.destroy', $jadwal->id));
        $response->assertRedirect(route('jadwal.index'));
        $this->assertDatabaseMissing('jadwal', ['id' => $jadwal->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function lihat_daftar_jadwal_lelang()
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($pembeli);

        Jadwal::insert([
            [
                'nama_barang' => 'Tuna',
                'tanggal_lelang' => now()->addDays(1)->format('Y-m-d'),
                'waktu_mulai' => '08:00:00',
                'lokasi' => 'TPI Muncar',
            ],
            [
                'nama_barang' => 'Cakalang',
                'tanggal_lelang' => now()->addDays(2)->format('Y-m-d'),
                'waktu_mulai' => '09:00:00',
                'lokasi' => 'TPI Muncar',
            ],
        ]);

        $response = $this->get(route('jadwal.index'));
        $response->assertStatus(200);
        $response->assertViewHas('jadwals');
    }

}
