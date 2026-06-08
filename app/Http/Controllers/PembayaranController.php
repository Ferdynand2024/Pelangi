<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\User;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        Config::$isProduction = config('midtrans.is_production');
    }

    // Tampilkan halaman pembayaran
    public function showPembayaran($id)
    {
        $produk = Produk::findOrFail($id);

        // Ambil pemenang aktif (status = 'belum')
        $pemenang = $produk->penawaran
            ->sortByDesc('jumlah_penawaran')
            ->firstWhere('status', 'belum');

        if (!$pemenang || $pemenang->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melakukan pembayaran');
        }

        // Tentukan batas pembayaran sesuai pemenang
        if ($pemenang->id === $produk->penawaran->sortByDesc('jumlah_penawaran')->first()->id) {
            // pemenang1
            $batasWaktuPembayaran = $produk->waktu_selesai->copy()->addMinutes(2);
        } else {
            // pemenang2
            $batasWaktuPembayaran = $produk->waktu_gugur_pemenang1->copy()->addMinutes(2);
        }

        if (now()->greaterThan($batasWaktuPembayaran)) {
            abort(403, 'Batas waktu pembayaran telah habis.');
        }

        $transaction_details = [
            'order_id' => 'lelang-' . $produk->id . '-' . time(),
            'gross_amount' => $pemenang->jumlah_penawaran,
        ];

        $customer_details = [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('pembeli.pembayaran', compact('produk', 'snapToken'));
    }

    public function chargePembayaran(Request $request, $id)
    {
        // Simpan data pembayaran dari Midtrans webhook/callback jika diperlukan
    }

    public function buktiPembayaran($id)
    {
        $produk = Produk::findOrFail($id);

        // Ambil semua penawaran urut terbesar
        $penawarans = $produk->penawaran()->orderByDesc('jumlah_penawaran')->get();

        $pemenang1 = $penawarans->get(0);
        $pemenang2 = $penawarans->get(1);

        // Cari pemenang sah yang sudah bayar
        $pemenang = null;
        if ($pemenang1 && $pemenang1->status === 'sudah') {
            $pemenang = $pemenang1;
        } elseif ($pemenang2 && $pemenang2->status === 'sudah') {
            $pemenang = $pemenang2;
        }

        // Validasi akses
        if (!$pemenang || $pemenang->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat bukti pembayaran');
        }

        $user = $pemenang->user;
        $tpi = User::where('role', 'tpi')->first();
        $orderId = 'lelang-' . $produk->id . '-' . $pemenang->id;
        $tanggalPembayaran = $pemenang->updated_at ?? $pemenang->created_at;

        return view('pembeli.bukti-pembayaran', compact(
            'produk',
            'pemenang',
            'user',
            'orderId',
            'tanggalPembayaran',
            'tpi'
        ));
    }

    public function downloadBuktiPembayaran($id)
    {
        $produk = Produk::findOrFail($id);

        $penawarans = $produk->penawaran()->orderByDesc('jumlah_penawaran')->get();
        $pemenang1 = $penawarans->get(0);
        $pemenang2 = $penawarans->get(1);

        $pemenang = null;
        if ($pemenang1 && $pemenang1->status === 'sudah') {
            $pemenang = $pemenang1;
        } elseif ($pemenang2 && $pemenang2->status === 'sudah') {
            $pemenang = $pemenang2;
        }

        if (!$pemenang || $pemenang->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengunduh bukti pembayaran ini');
        }

        $user = $pemenang->user;
        $tpi = User::where('role', 'tpi')->first();
        $orderId = 'lelang-' . $produk->id . '-' . $pemenang->id;
        $tanggalPembayaran = $pemenang->updated_at ?? $pemenang->created_at;

        $data = compact('produk', 'pemenang', 'user', 'tpi', 'orderId', 'tanggalPembayaran');
        $pdf = PDF::loadView('pembeli.bukti-pembayaran-pdf', $data);

        return $pdf->download('bukti-lelang-' . $produk->id . '.pdf');
    }


    public function konfirmasiPembayaran($id)
    {
        $produk = Produk::with('penawaran')->findOrFail($id);
        $pemenang = $produk->penawaran->sortByDesc('jumlah_penawaran')->firstWhere('status', 'belum');

        if (!$pemenang || $pemenang->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        // Batas pembayaran sesuai pemenang
        if ($pemenang->id === $produk->penawaran->sortByDesc('jumlah_penawaran')->first()->id) {
            $batasWaktuPembayaran = $produk->waktu_selesai->copy()->addMinutes(2);
        } else {
            $batasWaktuPembayaran = $produk->waktu_gugur_pemenang1->copy()->addMinutes(2);
        }

        if (now()->greaterThan($batasWaktuPembayaran)) {
            return redirect()->route('produk.index')->with('error', 'Waktu pembayaran telah habis.');
        }

        $pemenang->status = 'sudah';
        $pemenang->save();

        return redirect()->route('lelang.bukti-pembayaran', $produk->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}
