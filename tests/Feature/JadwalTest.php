<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Jadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class JadwalTest extends TestCase
{
    use RefreshDatabase;

    public function it_can_create_a_valid_jadwal()
    {
        $response = $this->post('/jadwal', [
            'nama_barang' => 'Ikan Tuna',
            'tanggal_lelang' => now()->addDay()->format('Y-m-d'),
            'waktu_mulai' => '10:00:00',
            'lokasi' => 'TPI Muncar',
        ]);

        $response->assertRedirect('/jadwal');
        $this->assertDatabaseHas('jadwal', [
            'nama_barang' => 'Ikan Tuna',
            'lokasi' => 'TPI Muncar',
        ]);
    }

    public function it_cannot_create_jadwal_in_the_past()
    {
        $response = $this->post('/jadwal', [
            'nama_barang' => 'Ikan Kakap',
            'tanggal_lelang' => now()->subDay()->format('Y-m-d'),
            'waktu_mulai' => '10:00:00',
            'lokasi' => 'Pelabuhan Lama',
        ]);

        $response->assertSessionHasErrors('tanggal_lelang');
        $this->assertDatabaseMissing('jadwal', [
            'nama_barang' => 'Ikan Kakap'
        ]);
    }

    public function it_can_update_jadwal()
    {
        $jadwal = Jadwal::create([
            'nama_barang' => 'Ikan Tongkol',
            'tanggal_lelang' => now()->addDay()->format('Y-m-d'),
            'waktu_mulai' => '09:00:00',
            'lokasi' => 'Gudang 2',
        ]);

        $response = $this->put("/jadwal/{$jadwal->id}", [
            'nama_barang' => 'Ikan Tongkol Super',
            'tanggal_lelang' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '11:00:00',
            'lokasi' => 'Gudang 3',
        ]);

        $response->assertRedirect('/jadwal');
        $this->assertDatabaseHas('jadwal', [
            'nama_barang' => 'Ikan Tongkol Super',
            'lokasi' => 'Gudang 3',
        ]);
    }

    public function it_cannot_update_jadwal_to_past_time()
    {
        $jadwal = Jadwal::create([
            'nama_barang' => 'Ikan Cakalang',
            'tanggal_lelang' => now()->addDay()->format('Y-m-d'),
            'waktu_mulai' => '08:00:00',
            'lokasi' => 'Dermaga 1',
        ]);

        $response = $this->put("/jadwal/{$jadwal->id}", [
            'nama_barang' => 'Ikan Cakalang',
            'tanggal_lelang' => now()->subDay()->format('Y-m-d'),
            'waktu_mulai' => '07:00:00',
            'lokasi' => 'Dermaga 1',
        ]);

        $response->assertSessionHasErrors('tanggal_lelang');
        $this->assertDatabaseHas('jadwal', [
            'nama_barang' => 'Ikan Cakalang'
        ]);
    }

    public function it_can_delete_jadwal()
    {
        $jadwal = Jadwal::create([
            'nama_barang' => 'Ikan Layur',
            'tanggal_lelang' => now()->addDay()->format('Y-m-d'),
            'waktu_mulai' => '13:00:00',
            'lokasi' => 'TPI Baru',
        ]);

        $response = $this->delete("/jadwal/{$jadwal->id}");

        $response->assertRedirect('/jadwal');
        $this->assertDatabaseMissing('jadwal', [
            'id' => $jadwal->id
        ]);
    }

    public function index_should_delete_old_jadwal_automatically()
    {
        // Jadwal yang sudah lewat
        Jadwal::create([
            'nama_barang' => 'Ikan Mujair',
            'tanggal_lelang' => now()->subDay()->format('Y-m-d'),
            'waktu_mulai' => '07:00:00',
            'lokasi' => 'Muncar',
        ]);

        // Jadwal yang masih valid
        Jadwal::create([
            'nama_barang' => 'Ikan Nila',
            'tanggal_lelang' => now()->addDay()->format('Y-m-d'),
            'waktu_mulai' => '09:00:00',
            'lokasi' => 'Muncar',
        ]);

        $this->get('/jadwal');

        $this->assertDatabaseMissing('jadwal', [
            'nama_barang' => 'Ikan Mujair'
        ]);

        $this->assertDatabaseHas('jadwal', [
            'nama_barang' => 'Ikan Nila'
        ]);
    }
}