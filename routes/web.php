<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TpiController;
use App\Http\Middleware\CheckRole; // Tambahkan ini
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\ProdukController; // Import ProdukController
use App\Http\Controllers\JadwalController; // Import JadwalController
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanLelangController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Mail;
use App\Models\Pembayaran;

// Route untuk halaman daftar lelang yang dapat diakses tanpa login


Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

Route::get('/test-email', function () {
    Mail::raw('Ini adalah email percobaan dari Laravel.', function ($message) {
        $message->to('alamat@email.com')
            ->subject('Tes Email dari Laravel');
    });

    return 'Email dikirim!';
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', CheckRole::class . ':admin,tpi,pembeli'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Penawaran store harus berada di sini karena pembeli juga bisa menawar
    Route::post('/produk/{id}/penawaran', [PenawaranController::class, 'store'])->name('penawaran.store');
});

Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/tpi', [TpiController::class, 'index'])->name('tpi.index');
    Route::get('/tpi/create', [TpiController::class, 'create'])->name('tpi.create');
    Route::post('/tpi/store', [TpiController::class, 'store'])->name('tpi.store');
    Route::get('/tpi/{user}/edit', [TpiController::class, 'edit'])->name('tpi.edit');
    Route::put('/tpi/{user}', [TpiController::class, 'update'])->name('tpi.update');
    Route::patch('/tpi/{user}/toggle-status', [TpiController::class, 'toggleStatus'])->name('tpi.toggle-status');

    Route::get('/pembeli', [PembeliController::class, 'index'])->name('pembeli.index');
});

Route::middleware(['auth', CheckRole::class . ':admin,tpi'])->group(function () {
    Route::get('/laporan-lelang', [LaporanLelangController::class, 'index'])->name('laporan.lelang');
    Route::get('/laporan/export', [LaporanLelangController::class, 'export'])->name('laporan.export');
});



Route::middleware(['auth', CheckRole::class . ':tpi'])->group(function () {

    // Route untuk Produk (tetap di sini jika hanya untuk TPI)
    // Resource route sudah mencakup index, create, store, edit, update, destroy
    Route::resource('produk', ProdukController::class)->except(['show']); // 'show' akan kita definisikan ulang untuk penawaran
    // Catatan: Jika Anda ingin menggunakan show bawaan Laravel untuk detail produk TPI,
    // maka pindahkan route showPenawaran ke path yang berbeda atau gunakan nama metode yang berbeda.

    // Route untuk memulai lelang
    Route::post('/lelang/{produk}/mulai', [ProdukController::class, 'mulai'])->name('lelang.mulai');

    // **PERBAIKAN:** Mengarahkan route 'lelang.selesai' ke metode 'selesaiLelang'
    Route::put('/lelang/{produk}/selesai', [ProdukController::class, 'selesaiLelang'])->name('lelang.selesai');

    // **PERBAIKAN:** Menggunakan nama metode 'showPenawaran' dan path yang lebih spesifik
    // Ini adalah route untuk melihat daftar penawaran untuk suatu produk
    Route::get('/produk/{produk}/penawaran', [ProdukController::class, 'showPenawaran'])->name('produk.penawaran');

    // Notifikasi ke penawar kedua
    Route::post('/produk/{id}/kirim-notif-cadangan', [ProdukController::class, 'kirimNotifCadangan'])->name('produk.kirimNotifCadangan');


    // **DIHAPUS/DIKOMEN:** Route ini kemungkinan redundan karena selesaiLelang sudah menentukan pemenang
    // Jika Anda benar-benar membutuhkan ini sebagai aksi terpisah, logika di controller harus diperbarui
    // Route::post('/produk/{produk}/tentukan-pemenang', [ProdukController::class, 'tentukanPemenang'])->name('produk.tentukanPemenang');

    // Contoh: Route untuk menutup lelang secara otomatis (bisa dipanggil oleh cron job)
    // Untuk pengembangan, diletakkan di sini, tapi untuk produksi, pertimbangkan middleware lain
    Route::get('/lelang/tutup-otomatis', [ProdukController::class, 'tutupLelangOtomatis'])->name('lelang.tutup-otomatis');
});

Route::middleware(['auth', CheckRole::class . ':tpi,pembeli'])->group(function () {
    // Route untuk manajemen jadwal lelang (CRUD)
    Route::resource('jadwal', JadwalController::class); // Hapus ->except(['show']) jika Anda punya show
    Route::get('/jadwallelang', [JadwalController::class, 'index1'])->name('jadwallelang');
});

Route::middleware(['auth', CheckRole::class . ':pembeli'])->group(function () {
    // Route untuk menampilkan produk yang sedang dilelang kepada pembeli
    Route::get('/lelang', [ProdukController::class, 'index2'])->name('lelang.index');
    // Route untuk menampilkan detail produk lelang spesifik (untuk pembeli)
    // Menggunakan 'show' dari ProdukController
    Route::get('/lelang/{id}', [ProdukController::class, 'show'])->name('lelang.show');

    Route::get('/lelang/{id}/pembayaran', [PembayaranController::class, 'showPembayaran'])->name('lelang.pembayaran');
    Route::post('/lelang/{id}/pembayaran/charge', [PembayaranController::class, 'chargePembayaran'])->name('lelang.pembayaran.charge');
    Route::get('/lelang/{id}/bukti-pembayaran', [PembayaranController::class, 'buktiPembayaran'])->name('lelang.bukti-pembayaran');
    Route::get('/bukti-pembayaran/{id}/download', [PembayaranController::class, 'downloadBuktiPembayaran'])->name('bukti-pembayaran.download');
    Route::get('/pembayaran/konfirmasi/{id}', [PembayaranController::class, 'konfirmasiPembayaran'])->name('pembayaran.konfirmasi');


    Route::middleware(['auth'])->group(function () {});
});


require __DIR__ . '/auth.php';
