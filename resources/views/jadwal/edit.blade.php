<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Lelang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('jadwal.update', $jadwal->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang', $jadwal->nama_barang)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="tanggal_lelang" :value="__('Tanggal Lelang')" />
                            {{-- Tambahkan event onchange --}}
                            <x-text-input id="tanggal_lelang" class="block mt-1 w-full" type="date" name="tanggal_lelang" :value="old('tanggal_lelang', $jadwal->tanggal_lelang)" required onchange="setMinTime()" />
                            <x-input-error :messages="$errors->get('tanggal_lelang')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="waktu_mulai" :value="__('Waktu Mulai (HH:MM)')" />
                            <x-text-input id="waktu_mulai" class="block mt-1 w-full" type="time" name="waktu_mulai" :value="old('waktu_mulai', $jadwal->waktu_mulai)" required step="60" />
                            <x-input-error :messages="$errors->get('waktu_mulai')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="lokasi" :value="__('Lokasi')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi', $jadwal->lokasi)" required />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                            <a href="{{ route('jadwal.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- KODE JAVASCRIPT UNTUK MEMBATASI PEMILIHAN TANGGAL/WAKTU --}}
    <script>
        // Fungsi yang sama dengan di create.blade.php
        function getTodayDateString() {
            const today = new Date();
            const yyyy = today.getFullYear();
            let mm = today.getMonth() + 1;
            let dd = today.getDate();

            if (mm < 10) mm = '0' + mm;
            if (dd < 10) dd = '0' + dd;

            return `${yyyy}-${mm}-${dd}`;
        }

        // Fungsi yang sama dengan di create.blade.php
        function getMinTimeString() {
            const now = new Date();
            now.setMinutes(now.getMinutes() + 1); // +1 menit buffer

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

            // 1. Terapkan Batas Minimum Tanggal (Hari Ini)
            // Ini mencegah pengguna mengedit jadwal ke tanggal sebelum hari ini.
            dateInput.setAttribute('min', getTodayDateString());

            // 2. Atur waktu saat inisialisasi
            setMinTime();
        });

    </script>
</x-app-layout>
