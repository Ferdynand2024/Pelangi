@php
// Ambil semua penawaran urut dari terbesar
$penawarans = $produk->penawaran->sortByDesc('jumlah_penawaran');

// Cek pemenang utama
$pemenang1 = $penawarans->first();
$pemenang2 = $penawarans->skip(1)->first();

// Cari pemenang yang benar-benar sudah bayar
$pemenang = null;

if ($pemenang1 && $pemenang1->status === 'sudah') {
    $pemenang = $pemenang1;
} elseif ($pemenang2 && $pemenang2->status === 'sudah') {
    $pemenang = $pemenang2;
}

$pemenangUserId = $pemenang->user_id ?? null;
@endphp

@if(Auth::id() === $pemenangUserId && $pemenang)
<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Bukti Pembayaran Lelang</h2>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pembayaran Berhasil</h5>
                            <i class="bi bi-check-circle-fill fs-4"></i>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 text-center">
                                <h4 class="fw-semibold">Terima kasih telah melakukan pembayaran!</h4>
                                <p class="text-muted">Berikut adalah detail transaksi Anda:</p>
                            </div>

                            <table class="table table-bordered">
                                <tr>
                                    <th>ID Transaksi</th>
                                    <td>{{ $orderId }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pembeli</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email Pembeli</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Nama TPI</th>
                                    <td>{{ $tpi->name ?? 'Tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th>Email TPI</th>
                                    <td>{{ $tpi->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Ikan</th>
                                    <td>{{ $produk->jenis_ikan }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Penawaran</th>
                                    <td>Rp {{ number_format($pemenang->jumlah_penawaran, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td><span class="badge bg-success">Sukses</span></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <td>{{ \Carbon\Carbon::parse($tanggalPembayaran)->format('d M Y, H:i') }}</td>
                                </tr>
                            </table>
                            <div class="text-center mt-4">
                                <a href="{{ route('bukti-pembayaran.download', $produk->id) }}" class="btn btn-success">
                                    <i class="bi bi-download"></i> Download Bukti Pembayaran (PDF)
                                </a>
                            </div>
                            <div class="text-center mt-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                        <div class="card-footer text-center text-muted small">
                            &copy; {{ date('Y') }} Sistem Lelang Ikan Banyuwangi. Semua hak dilindungi.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
