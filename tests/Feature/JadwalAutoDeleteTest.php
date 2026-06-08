<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Jadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class JadwalAutoDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected $jadwal;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat satu jadwal lelang contoh
        $this->jadwal = Jadwal::create([
            'nama_barang' => 'Tuna',
            'tanggal_lelang' => now()->toDateString(),
            'waktu_mulai' => now()->subMinutes(60), // default sudah lewat 60 menit
            'lokasi' => 'TPI Muncar',
        ]);
    }

    /** @test TC-DB-001 */
    public function penghapusan_tepat_waktu_fokus_tabel()
    {
        // Simulasikan waktu sistem tepat 60 menit setelah waktu_mulai
        Carbon::setTestNow(Carbon::parse($this->jadwal->waktu_mulai)->addMinutes(60));

        // Jalankan logika penghapusan otomatis
        $this->hapusJadwalOtomatis();

        // Pastikan jadwal sudah dihapus
        $this->assertDatabaseMissing('jadwal', [
            'id' => $this->jadwal->id,
        ]);
    }

    /** @test TC-DB-004 */
    public function jadwal_bertahan_sebelum_trigger()
    {
        // Reset database dulu
        $this->refreshDatabase();

        // Buat ulang jadwal baru
        $jadwal = Jadwal::create([
            'nama_barang' => 'Cakalang',
            'tanggal_lelang' => now()->toDateString(),
            'waktu_mulai' => now()->subMinutes(59)->subSeconds(59), // baru 59:59 lewat
            'lokasi' => 'TPI Puger',
        ]);

        // Simulasikan waktu sistem belum mencapai 60 menit
        Carbon::setTestNow(Carbon::parse($jadwal->waktu_mulai)->addMinutes(59)->addSeconds(59));

        // Jalankan logika penghapusan otomatis
        $this->hapusJadwalOtomatis();

        // Pastikan jadwal masih ada
        $this->assertDatabaseHas('jadwal', [
            'id' => $jadwal->id,
            'nama_barang' => 'Cakalang',
        ]);
    }

    /**
     * Fungsi simulasi logika penghapusan otomatis jadwal.
     * (biasanya dijalankan via cron/scheduler di Laravel)
     */
    private function hapusJadwalOtomatis()
    {
        $now = Carbon::now();

        Jadwal::where('waktu_mulai', '<=', $now->copy()->subMinutes(60))
            ->delete();
    }
}
