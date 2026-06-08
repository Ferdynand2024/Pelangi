<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Halaman Lelang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 font-bold text-center">Lelang Ikan Sedang Berlangsung</h3>

                    <div class="row justify-content-center w-100 gx-4 gy-4">
                        @forelse($produk as $item)
                            <div class="col-md-6 col-lg-4 mb-4 d-flex align-items-stretch">
                                <div class="card h-100 shadow border-0 w-100">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" 
                                             class="card-img-top img-fluid object-cover rounded-top" 
                                             alt="{{ $item->jenis_ikan }}" 
                                             style="height: 250px; width: 100%; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/400x250?text=No+Image" 
                                             class="card-img-top img-fluid object-cover rounded-top" 
                                             alt="No Image"
                                             style="height: 250px; width: 100%; object-fit: cover;">
                                    @endif

                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Nama Ikan:</strong> {{ $item->jenis_ikan }}</h5>
                                        <p class="mb-1"><strong>Berat:</strong> {{ $item->berat }} kg</p>
                                        <p class="mb-1"><strong>Harga Awal:</strong> Rp{{ number_format($item->harga_awal, 0, ',', '.') }}</p>
                                        <p class="mb-1">
                                            <strong>Waktu Selesai:</strong>
                                            @if($item->waktu_selesai)
                                                <span id="countdown-{{ $item->id }}" data-timestamp="{{ $item->waktu_selesai->timestamp * 1000 }}"></span>
                                            @else
                                                -
                                            @endif
                                        </p>
                                        <p class="mb-1"><strong>Deskripsi:</strong> {{ Str::limit($item->deskripsi, 100) }}</p>
                                    </div>

                                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between align-items-center">
                                        <a href="{{ route('lelang.show', $item->id) }}" class="btn btn-primary">Ikuti Lelang</a>
                                        @if (auth()->check() && auth()->user()->isAdmin())
                                            @if ($item->status_lelang == 'dibuka')
                                                <form action="{{ route('lelang.selesai', $item->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin mengakhiri lelang produk ini?')">
                                                        Selesai Lelang
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <div class="alert alert-info">Belum ada produk yang tersedia untuk dilelang saat ini.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCountdown() {
            const countdownElements = document.querySelectorAll('[id^="countdown-"]');
            countdownElements.forEach(element => {
                const endTime = parseInt(element.getAttribute('data-timestamp'));
                const now = new Date().getTime();
                const difference = endTime - now;

                if (difference > 0) {
                    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));

                    let countdownText = "";
                    if (days > 0) {
                        countdownText += days + " hari ";
                    }
                    countdownText += hours + " jam " + minutes + " menit";
                    element.textContent = countdownText;
                } else {
                    element.textContent = "Lelang Selesai";
                }
            });
        }

        setInterval(updateCountdown, 1000);
    </script>
</x-app-layout>
