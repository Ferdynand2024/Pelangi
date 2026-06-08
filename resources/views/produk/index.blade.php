<x-app-layout>
     @slot('title', 'Produk')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('produk.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Tambah Produk') }}
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Foto
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Ikan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Berat (kg)
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Awal (Rp)
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Selesai
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($produk as $p)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($p->foto)
                                                <img src="{{ asset('storage/' . $p->foto) }}" 
                                                     alt="{{ $p->jenis_ikan }}" 
                                                     class="rounded cursor-pointer object-cover"
                                                     onclick="showFullImage(this)"
                                                     style="height: 64px; width: 96px; object-fit: cover;">
                                            @else
                                                <span>No Foto</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->jenis_ikan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->berat }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($p->harga_awal, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">{{ $p->deskripsi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($p->status_lelang == 'belum_dimulai')
                                                <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">Belum Dimulai</span>
                                            @elseif ($p->status_lelang == 'dibuka')
                                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Dibuka</span>
                                            @elseif ($p->status_lelang == 'ditutup')
                                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Ditutup</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($p->status_lelang == 'dibuka' && $p->waktu_selesai)
                                                <span id="countdown-admin-{{ $p->id }}" data-timestamp="{{ $p->waktu_selesai->timestamp * 1000 }}"></span>
                                            @elseif ($p->waktu_selesai)
                                                {{ $p->waktu_selesai->format('d M Y, H:i:s') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex space-x-2">
                                                @if ($p->status_lelang == 'belum_dimulai')
                                                    <form action="{{ route('lelang.mulai', $p->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                                            Mulai Lelang
                                                        </button>
                                                    </form>
                                                @elseif ($p->status_lelang == 'dibuka')
                                                    <form action="{{ route('lelang.selesai', $p->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin mengakhiri lelang produk ini?')">
                                                            Selesai Lelang
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('produk.edit', $p->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('produk.destroy', $p->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                                </form>
                                                <a href="{{ route('produk.penawaran', $p->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    Lihat Penawaran
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="full-image-container" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); z-index: 10000; justify-content: center; align-items: center;" onclick="hideFullImage()">
        <img id="full-image" src="" style="max-width: 90%; max-height: 90%;">
    </div>

    <script>
        function showFullImage(img) {
            var container = document.getElementById('full-image-container');
            var fullImg = document.getElementById('full-image');
            fullImg.src = img.src;
            container.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function hideFullImage() {
            var container = document.getElementById('full-image-container');
            container.style.display = 'none';
            document.body.style.overflow = '';
        }

        function updateAdminCountdown() {
            const countdownElements = document.querySelectorAll('[id^="countdown-admin-"]');
            countdownElements.forEach(element => {
                const endTime = parseInt(element.getAttribute('data-timestamp'));
                const now = new Date().getTime();
                const difference = endTime - now;

                if (difference > 0) {
                    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                    let countdownText = "";
                    if (days > 0) countdownText += days + " hari ";
                    countdownText += hours + " jam " + minutes + " menit " + seconds + " detik";
                    element.textContent = countdownText;
                } else {
                    element.textContent = "Lelang Selesai";
                }
            });
        }

        setInterval(updateAdminCountdown, 1000);
    </script>
</x-app-layout>
