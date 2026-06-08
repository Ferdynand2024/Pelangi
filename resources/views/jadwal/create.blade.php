<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Lelang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('jadwal.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="tanggal_lelang" :value="__('Tanggal Lelang')" />
                            {{-- Tambahkan event onchange untuk memicu pengecekan waktu saat tanggal diubah --}}
                            <x-text-input id="tanggal_lelang" class="block mt-1 w-full" type="date" name="tanggal_lelang" :value="old('tanggal_lelang')" required onchange="setMinTime()" />
                            <x-input-error :messages="$errors->get('tanggal_lelang')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="waktu_mulai" :value="__('Waktu Mulai (HH:MM)')" />
                            <x-text-input id="waktu_mulai" class="block mt-1 w-full" type="time" name="waktu_mulai" :value="old('waktu_mulai')" required step="60" />
                            <x-input-error :messages="$errors->get('waktu_mulai')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="lokasi" :value="__('Lokasi')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Jadwal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- KODE JAVASCRIPT UNTUK MEMBATASI PEMILIHAN TANGGAL/WAKTU --}}
    <script>
        // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        function getTodayDateString() {
            const today = new Date();
            const yyyy = today.getFullYear();
            let mm = today.getMonth() + 1;
            let dd = today.getDate();

            if (mm < 10) mm = '0' + mm;
            if (dd < 10) dd = '0' + dd;

            return `${yyyy}-${mm}-${dd}`;
        }

        // Fungsi untuk mendapatkan waktu saat ini + 1 menit dalam format HH:MM
        function getMinTimeString() {
            const now = new Date();

            // Tambahkan 1 menit untuk memastikan waktu saat ini tidak terlewat
            now.setMinutes(now.getMinutes() + 1);

            let hh = now.getHours();
            let mm = now.getMinutes();

            if (hh < 10) hh = '0' + hh;
            if (mm < 10) mm = '0' + mm;

            return `${hh}:${mm}`;
        }

        // Fungsi utama untuk mengatur batas minimum waktu
        function setMinTime() {
            const dateInput = document.getElementById('tanggal_lelang');
            const timeInput = document.getElementById('waktu_mulai');

            const selectedDateString = dateInput.value;
            const todayDateString = getTodayDateString();
            const currentMinTime = getMinTimeString();

            if (selectedDateString === todayDateString) {
                // Jika tanggal yang dipilih adalah HARI INI
                timeInput.setAttribute('min', currentMinTime);

                // Jika waktu yang sudah dipilih di masa lalu, atur ke waktu minimum
                if (timeInput.value && timeInput.value < currentMinTime) {
                    timeInput.value = currentMinTime;
                }
            } else {
                // Jika tanggal di masa depan, hapus batasan minimum waktu
                timeInput.removeAttribute('min');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('tanggal_lelang');
            const timeInput = document.getElementById('waktu_mulai');

            // 1. Terapkan Batas Minimum Tanggal (Hari Ini)
            dateInput.setAttribute('min', getTodayDateString());

            // 2. Atur waktu saat inisialisasi
            setMinTime();

            // 3. Atur nilai waktu awal jika tanggalnya hari ini dan input kosong
            if (dateInput.value === getTodayDateString() && !timeInput.value) {
                timeInput.value = getMinTimeString();
            }
        });

    </script>
</x-app-layout>
