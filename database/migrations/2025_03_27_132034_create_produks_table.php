<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable(); // Menyimpan path ke foto produk, bisa null
            $table->string('jenis_ikan');
            $table->decimal('berat', 10, 2); // Menyimpan berat dengan 2 angka desimal
            $table->decimal('harga_awal', 10, 2); // Menyimpan harga dengan 2 angka desimal
            $table->text('deskripsi');
            $table->enum('status_lelang', ['belum_dimulai', 'dibuka', 'ditutup'])->default('belum_dimulai'); // Status lelang produk
            $table->timestamp('waktu_mulai')->nullable(); // Waktu lelang dimulai
            $table->timestamp('waktu_selesai')->nullable(); // Waktu lelang berakhir
            $table->timestamp('waktu_gugur_pemenang1')->nullable();
            $table->unsignedBigInteger('pemenang_lelang_id')->nullable(); // ID user pemenang lelang
            $table->decimal('harga_akhir', 10, 2)->nullable(); // Harga penawaran terakhir/tertinggi
            $table->timestamps();

            $table->foreign('pemenang_lelang_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};