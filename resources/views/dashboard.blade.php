<x-app-layout>
    @slot('title', 'Dashboard')

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Selamat Datang di Pelangi!') }}
            </h2>
        </div>
    </x-slot>

    @php
        $userRole = auth()->user()->role ?? 'pembeli';
        $infoData = [
            'admin' => [
                'title' => 'Panel Administrasi',
                'color' => 'red',
                'text' => 'Selamat datang di panel administrasi Pelangi! Sebagai admin, Anda memiliki kontrol penuh untuk mengelola sistem pelelangan, memantau aktivitas TPI dan pembeli, serta mengatur kebijakan lelang. Pastikan untuk selalu memantau aktivitas transaksi dan menjaga integritas sistem untuk mendukung transparansi pelelangan ikan di Banyuwangi.'
            ],
            'tpi' => [
                'title' => 'Sistem TPI Pelangi',
                'color' => 'green',
                'text' => 'Selamat datang di sistem TPI Pelangi Banyuwangi! Sebagai pengelola TPI, Anda dapat mendaftarkan hasil tangkapan nelayan, mengatur jadwal lelang, dan memantau proses pelelangan. Pastikan untuk selalu memperbarui informasi stok ikan, kualitas, dan harga dasar untuk memastikan proses lelang berjalan lancar dan menguntungkan semua pihak.'
            ],
            'pembeli' => [
                'title' => 'Sistem Pelelangan Ikan',
                'color' => 'blue',
                'text' => 'Selamat datang di sistem pelelangan ikan Pelangi Banyuwangi! Sebagai pembeli, Anda dapat mengikuti lelang ikan segar langsung dari nelayan terpercaya, melihat jadwal lelang, dan melakukan penawaran. Pastikan untuk memeriksa jadwal lelang secara berkala dan siapkan saldo yang cukup untuk mendapatkan ikan berkualitas terbaik dengan harga terbaik.'
            ]
        ];
        $currentInfo = $infoData[$userRole];
    @endphp

    <!-- Informasi Utama -->
    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="bg-{{ $currentInfo['color'] }}-100 rounded-full p-2 flex-shrink-0">
                    <svg class="w-5 h-5 text-{{ $currentInfo['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">{{ $currentInfo['title'] }}</h4>
                    <p class="text-gray-600 text-sm mt-1">
                        {{ $currentInfo['text'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahan khusus untuk pembeli -->
    @if ($userRole === 'pembeli')
        <!-- Jenis-Jenis Ikan Populer -->
        <div class="mt-6 bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🎣 Jenis-Jenis Ikan Populer</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="border rounded-lg overflow-hidden shadow-sm">
                    <div class="p-4">
                        <h4 class="font-bold text-blue-700">Tuna</h4>
                        <p class="text-sm text-gray-600">Ikan laut bernilai tinggi, cocok untuk ekspor dan konsumsi lokal.</p>
                    </div>
                </div>
                <div class="border rounded-lg overflow-hidden shadow-sm">
                    <div class="p-4">
                        <h4 class="font-bold text-blue-700">Cakalang</h4>
                        <p class="text-sm text-gray-600">Populer di pasar lokal, sering digunakan dalam makanan kaleng dan masakan khas.</p>
                    </div>
                </div>
                <div class="border rounded-lg overflow-hidden shadow-sm">
                    <div class="p-4">
                        <h4 class="font-bold text-blue-700">Kembung</h4>
                        <p class="text-sm text-gray-600">Terjangkau dan banyak dicari, ideal untuk konsumsi harian.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Lelang -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-6 rounded">
            <h3 class="text-blue-800 font-semibold text-base">💡 Tips Menang Lelang</h3>
            <ul class="list-disc list-inside text-sm text-gray-700 mt-2 space-y-1">
                <li>Selalu cek jadwal lelang terbaru setiap hari.</li>
                <li>Siapkan saldo mencukupi sebelum melakukan penawaran.</li>
                <li>Perhatikan kualitas dan jenis ikan sebelum bidding.</li>
            </ul>
        </div>
    @endif
</x-app-layout>