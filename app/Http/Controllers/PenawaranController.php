<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenawaranController extends Controller
{
    public function store(Request $request, $produkId)
    {
        $request->validate([
            'jumlah_penawaran' => 'required|numeric|min:1',
        ]);

        $produk = Produk::with('penawaran')->findOrFail($produkId);

        // Cek waktu lelang
        if (now()->lt($produk->waktu_mulai) || now()->gt($produk->waktu_selesai)) {
            return back()->with('error', 'Lelang tidak aktif.');
        }

        // Ambil harga tertinggi saat ini
        $hargaTertinggi = $produk->penawaran->max('jumlah_penawaran') ?? $produk->harga_awal;

        if ($request->jumlah_penawaran <= $hargaTertinggi) {
            return back()->with('error', 'Tawaran harus lebih tinggi dari harga tertinggi saat ini (Rp ' . number_format($hargaTertinggi, 0, ',', '.') . ').');
        }

        // Simpan penawaran baru
        Penawaran::create([
            'produk_id' => $produkId,
            'user_id' => Auth::id(),
            'jumlah_penawaran' => $request->jumlah_penawaran,
            'status' => 'pending', // default, nanti kita update di bawah
        ]);

        // 🔹 Update status semua penawaran setelah bid baru masuk
        $penawarans = Penawaran::where('produk_id', $produkId)
            ->orderBy('jumlah_penawaran', 'desc')
            ->get();

        foreach ($penawarans as $i => $penawaran) {
            if ($i === 0) {
                $penawaran->status = 'belum'; // pemenang utama sementara
            } elseif ($i === 1) {
                $penawaran->status = 'cadangan'; // pemenang kedua sementara
            } else {
                $penawaran->status = 'gugur'; // otomatis kalah
            }
            $penawaran->save();
        }

        return back()->with('success', 'Penawaran berhasil dikirim!');
    }
}
