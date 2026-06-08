<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">Pembayaran Lelang - {{ $produk->jenis_ikan }}</h2>
    </x-slot>

    @php
    // Ambil pemenang utama yang siap bayar
    $pemenang1 = $produk->penawaran->sortByDesc('jumlah_penawaran')->first();
    $pemenang2 = $produk->penawaran->sortByDesc('jumlah_penawaran')->skip(1)->first();

    $pemenang1UserId = $pemenang1?->user_id;
    $pemenang2UserId = $pemenang2?->user_id;

    // Tentukan pemenang aktif untuk pembayaran
    $pemenangAktif = null;
    if ($pemenang1 && $pemenang1->status === 'belum' && now()->gt($produk->waktu_selesai)) {
    $pemenangAktif = $pemenang1;
    } elseif ($pemenang2 && $pemenang2->status === 'belum' && $pemenang1 && $pemenang1->status === 'gugur') {
    $pemenangAktif = $pemenang2;
    }

    $jumlahPembayaran = $pemenangAktif ? $pemenangAktif->jumlah_penawaran : null;
    @endphp

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($pemenangAktif && Auth::id() === $pemenangAktif->user_id)
                <div class="card shadow-lg mb-4">
                    <div class="card-body text-center">
                        <h4 class="mb-3"><i class="bi bi-cash-coin me-2"></i> Total Pembayaran</h4>
                        <h3 class="text-success mb-4">
                            <strong>Rp {{ number_format($jumlahPembayaran, 0, ',', '.') }}</strong>
                        </h3>
                        <p class="text-muted mb-4">
                            Silakan lanjutkan pembayaran untuk menyelesaikan proses lelang. Pembayaran dilakukan secara aman melalui Midtrans.
                        </p>

                        <button id="pay-button" class="btn btn-primary btn-lg px-5 rounded-pill">
                            <i class="bi bi-credit-card me-2"></i> Lanjutkan Pembayaran
                        </button>

                        {{-- Countdown --}}
                        <p id="countdown" class="mt-3 text-danger fw-bold"></p>
                        <span id="waktu-selesai" data-timestamp="{{ $produk->waktu_selesai?->timestamp * 1000 }}"></span>
                        <span id="waktu-gugur" data-timestamp="{{ $produk->waktu_gugur_pemenang1?->timestamp * 1000 }}"></span>
                    </div>
                </div>
                @elseif(Auth::id() === $pemenang1UserId && $pemenang1->status === 'sudah')
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h3 class="text-success mb-4"><strong>Anda Telah Melakukan Pembayaran</strong></h3>
                        <a href="{{ route('lelang.bukti-pembayaran', $produk->id) }}" class="btn btn-primary rounded-pill">
                            Bukti Pembayaran
                        </a>
                    </div>
                </div>
                @else
                <div class="alert alert-warning text-center">
                    Anda tidak memiliki hak melakukan pembayaran untuk produk ini.
                </div>
                @endif
            </div>
        </div>
    </div>


    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('pembayaran.konfirmasi', $produk->id) }}";
                    },
                    onPending: function(result) {
                        alert('Pembayaran dalam status pending. Silakan cek status pembayaran.');
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal: ' + JSON.stringify(result));
                    },
                    onClose: function() {
                        alert('Anda menutup popup pembayaran tanpa menyelesaikan transaksi');
                    }
                });
            });
        }

        // Script countdown
        document.addEventListener('DOMContentLoaded', () => {
            const countdownEl = document.getElementById('countdown');
            const waktuSelesaiEl = document.getElementById('waktu-selesai');
            const waktuGugurEl = document.getElementById('waktu-gugur');
            if (!countdownEl || !waktuSelesaiEl) return;

            let batasWaktu;
            const waktuSelesai = parseInt(waktuSelesaiEl.dataset.timestamp);
            const waktuGugur = waktuGugurEl ? parseInt(waktuGugurEl.dataset.timestamp) : null;

            // Jika pemenang1 gugur, hitung dari waktu gugur
            if (waktuGugur) {
                batasWaktu = waktuGugur + 2 * 60 * 1000; // 2 menit dari gugur
            } else {
                batasWaktu = waktuSelesai + 2 * 60 * 1000; // 2 menit dari lelang selesai
            }

            function updateCountdown() {
                const now = Date.now();
                let diff = batasWaktu - now;

                if (diff <= 0) {
                    countdownEl.textContent = 'Waktu pembayaran telah habis';
                    clearInterval(timer);
                    return;
                }

                const minutes = Math.floor(diff / 60000);
                const seconds = Math.floor((diff % 60000) / 1000);

                countdownEl.textContent = `${minutes} menit ${seconds} detik`;
            }

            updateCountdown();
            const timer = setInterval(updateCountdown, 1000);
        });
    </script>
</x-app-layout>