<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use App\Models\Produk;
use App\Models\User; // Tambahkan ini jika Anda perlu mengakses model User
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http; // Tambahkan ini untuk menggunakan Session::flash

class ProdukController extends Controller
{
    /**     
     * Menampilkan daftar produk (untuk admin/TPI).
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    /**
     * Menampilkan form untuk menambahkan produk baru (untuk TPI).
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('produk.create');
    }

    /**
     * Menampilkan daftar produk yang sedang dilelang (untuk pembeli).
     *
     * @return \Illuminate\View\View
     */
    public function index2(): View
    {
        $produk = Produk::where('status_lelang', 'dibuka')->get();
        return view('pembeli.lelang', compact('produk'));
    }

    /**
     * Menampilkan detail produk lelang (untuk pembeli).
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(int $id): View
    {
        $produk = Produk::findOrFail($id);

        // Gunakan method cekPemenang untuk update status otomatis
        $this->cekPemenang($produk);

        return view('pembeli.lelangshow', compact('produk'));
    }



    // Mengubah show2 menjadi showPenawaran agar lebih eksplisit dan konsisten dengan route
    public function showPenawaran(int $id): View
    {
        $produk = Produk::findOrFail($id);
        // Memuat penawaran terkait dengan pengguna yang menawar
        $penawarans = $produk->penawaran()->with('user')->orderBy('jumlah_penawaran', 'desc')->get();
        return view('produk.penawaran', compact('produk', 'penawarans'));
    }


    /**
     * Menyimpan produk baru ke database (untuk TPI).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi data yang diinputkan oleh pengguna
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jenis_ikan' => 'required|string|max:255',
            'berat' => 'required|numeric|min:0',
            'harga_awal' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            // Simpan foto ke direktori public/uploads
            $fotoPath = 'uploads/' . $fotoName;
            Storage::disk('public')->put($fotoPath, file_get_contents($foto));
        }

        $produk = new Produk();
        $produk->foto = $fotoPath;
        $produk->jenis_ikan = $request->input('jenis_ikan');
        $produk->berat = $request->input('berat');
        $produk->harga_awal = $request->input('harga_awal');
        $produk->deskripsi = $request->input('deskripsi');
        // Status lelang default adalah 'belum_dimulai' sesuai migrasi
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit produk (untuk TPI).
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id): View
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Memperbarui produk di database (untuk TPI).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Validasi data yang diinputkan oleh pengguna
        $validator = Validator::make($request->all(), [
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // foto tidak required untuk update
            'jenis_ikan' => 'required|string|max:255',
            'berat' => 'required|numeric|min:0',
            'harga_awal' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $produk = Produk::findOrFail($id);

        // Proses upload foto jika ada foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $fotoPath = 'uploads/' . $fotoName;
            Storage::disk('public')->put($fotoPath, file_get_contents($foto));
            $produk->foto = $fotoPath;
        }

        $produk->jenis_ikan = $request->input('jenis_ikan');
        $produk->berat = $request->input('berat');
        $produk->harga_awal = $request->input('harga_awal');
        $produk->deskripsi = $request->input('deskripsi');
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database (untuk TPI).
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $produk = Produk::findOrFail($id);

        // Hapus foto terkait jika ada
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Memulai lelang untuk produk tertentu (untuk TPI/Admin).
     * Digunakan oleh tombol "Mulai Lelang".
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mulai(Produk $produk): RedirectResponse
    {
        if ($produk->status_lelang !== 'belum_dimulai') {
            return redirect()->back()->with('error', 'Lelang sudah dimulai atau ditutup.');
        }

        $produk->update([
            'status_lelang' => 'dibuka',
            'waktu_mulai' => now(),
            'waktu_selesai' => now()->addMinutes(5), // Contoh: lelang berjalan 5 menit
        ]);

        return redirect()->back()->with('success', 'Lelang untuk produk ' . $produk->jenis_ikan . ' telah dimulai dan akan berakhir pada ' . $produk->waktu_selesai->format('d M Y, H:i:s'));
    }

    /**
     * Mengakhiri lelang untuk produk tertentu dan menentukan pemenangnya.
     * Menggantikan method 'selesai' dan 'tentukanPemenang' yang terpisah.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selesaiLelang(Produk $produk): RedirectResponse
    {
        if ($produk->status_lelang !== 'dibuka') {
            return redirect()->back()->with('error', 'Lelang tidak dalam status dibuka untuk diakhiri.');
        }

        DB::transaction(function () use ($produk) {
            // Ambil 2 penawaran tertinggi sekaligus
            $highestBids = Penawaran::where('produk_id', $produk->id)
                ->orderBy('jumlah_penawaran', 'desc')
                ->take(2)
                ->get();

            $winnerId = null;
            $backupWinnerId = null;

            if ($highestBids->isNotEmpty()) {
                // Pemenang utama
                $winnerId = $highestBids[0]->user_id;
                $produk->pemenang_lelang_id = $winnerId;
                $produk->harga_akhir = $highestBids[0]->jumlah_penawaran;

                // Pemenang cadangan (jika ada)
                if ($highestBids->count() > 1) {
                    $backupWinnerId = $highestBids[1]->user_id;
                    $produk->pemenang_cadangan_id = $backupWinnerId; // butuh kolom baru di tabel produk
                }
            }

            $produk->status_lelang = 'ditutup';
            if (is_null($produk->waktu_selesai)) {
                $produk->waktu_selesai = now();
            }
            $produk->save();

            // Notifikasi
            $allBidders = Penawaran::where('produk_id', $produk->id)
                ->distinct('user_id')
                ->pluck('user_id');

            foreach ($allBidders as $bidderId) {
                if ($bidderId == $winnerId) {
                    Session::flash('lelang_status_' . $bidderId, [
                        'type' => 'success',
                        'message' => 'Selamat! Anda pemenang utama "' . $produk->jenis_ikan . '".',
                        'status' => 'won'
                    ]);
                } elseif ($bidderId == $backupWinnerId) {
                    Session::flash('lelang_status_' . $bidderId, [
                        'type' => 'info',
                        'message' => 'Anda adalah pemenang cadangan "' . $produk->jenis_ikan . '". Akan dipilih jika pemenang utama gugur.',
                        'status' => 'backup'
                    ]);
                } else {
                    Session::flash('lelang_status_' . $bidderId, [
                        'type' => 'warning',
                        'message' => 'Anda kalah di lelang "' . $produk->jenis_ikan . '".',
                        'status' => 'lost'
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Lelang ditutup. Pemenang utama dan cadangan sudah ditentukan.');
    }



    public function cekPemenang($produk)
    {
        $penawarans = $produk->penawaran()->orderBy('jumlah_penawaran', 'desc')->get();

        if ($penawarans->isEmpty()) {
            return null;
        }

        $pemenang1 = $penawarans[0];

        // Jika pemenang utama telat bayar
        if ($pemenang1->status === 'belum' && now()->gt($produk->waktu_selesai->copy()->addMinutes(2))) {
            $pemenang1->status = 'gugur';
            $pemenang1->save();

            // simpan waktu gugur
            $produk->waktu_gugur_pemenang1 = now();
            $produk->save();

            // pemenang cadangan
            if (isset($penawarans[1])) {
                $pemenang2 = $penawarans[1];

                // Jika pemenang utama gugur, pemenang kedua jadi belum
                if ($pemenang2->status !== 'sudah') {
                    $pemenang2->status = 'belum';
                    $pemenang2->save();

                    $produk->pemenang_lelang_id = $pemenang2->user_id;
                    $produk->save();
                }

                // Cek apakah pemenang kedua juga telat bayar (misal 2 menit setelah waktu gugur pemenang1)
                if ($pemenang2->status === 'belum' && now()->gt($produk->waktu_gugur_pemenang1->copy()->addMinutes(2))) {
                    $pemenang2->status = 'gugur';
                    $pemenang2->save();

                    // Reset pemenang lelang jika semua gagal
                    $produk->pemenang_lelang_id = null;
                    $produk->save();

                    return null;
                }

                return $pemenang2;
            }
            return null;
        }


        return $pemenang1;
    }
    // tambahkan di atas

    public function kirimNotifCadangan($id)
    {
        $produk = Produk::with(['penawaran.user'])->findOrFail($id);

        // Ambil penawaran tertinggi dan kedua
        $penawarans = $produk->penawaran->sortByDesc('jumlah_penawaran')->values();
        $pemenangUtama = $penawarans->get(0);
        $pemenangKedua = $penawarans->get(1);

        if (!$pemenangUtama || !$pemenangKedua) {
            return back()->with('error', 'Tidak ditemukan data penawar utama atau kedua.');
        }

        // Cek status pemenang utama
        if ($pemenangUtama->status !== 'gugur') {
            return back()->with('error', 'Pemenang utama belum dinyatakan gugur.');
        }

        // Ambil nomor telepon penawar kedua
        $nomor = preg_replace('/[^0-9]/', '', $pemenangKedua->user->phone);
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }

        // Susun pesan WhatsApp
        $text = "Halo {$pemenangKedua->user->name},\n\n"
            . "🎉 Selamat! Anda menjadi *penawar kedua* untuk produk lelang berikut:\n\n"
            . "🐟 Jenis Ikan: {$produk->jenis_ikan}\n"
            . "⚖️ Berat: {$produk->berat} kg\n"
            . "💰 Tawaran Anda: Rp " . number_format($pemenangKedua->jumlah_penawaran, 0, ',', '.') . "\n\n"
            . "Pemenang utama telah *didiskualifikasi*, sehingga Anda berhak untuk melanjutkan pembayaran sebagai pemenang baru.\n\n"
            . "Segera lakukan pembayaran sebelum waktu berakhir.\n"
            . "Terima kasih telah mengikuti lelang di TPI Digital 🎣";

        // Kirim via Fonnte API
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => $text,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Notifikasi berhasil dikirim ke penawar kedua: ' . $pemenangKedua->user->name);
        } else {
            return back()->with('error', 'Gagal mengirim pesan WhatsApp.');
        }
    }
}
