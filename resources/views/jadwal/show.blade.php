<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Jadwal Lelang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong>{{ __('Nama Barang') }}:</strong> {{ $jadwal->nama_barang }}
                    </div>
                    <div class="mb-4">
                        <strong>{{ __('Tanggal Lelang') }}:</strong> {{ $jadwal->tanggal_lelang }}
                    </div>
                    <div class="mb-4">
                        <strong>{{ __('Waktu Mulai') }}:</strong> {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}
                    </div>
                    <div class="mb-4">
                        <strong>{{ __('Lokasi') }}:</strong> {{ $jadwal->lokasi }}
                    </div>
                    <div class="flex items-center justify-start mt-4">
                        <a href="{{ route('jadwal.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            {{ __('Kembali ke Daftar') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>