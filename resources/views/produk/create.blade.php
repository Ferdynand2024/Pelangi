<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-input rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
                            @error('foto')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_ikan" class="block text-sm font-medium text-gray-700">Jenis Ikan</label>
                            <input type="text" name="jenis_ikan" id="jenis_ikan" value="{{ old('jenis_ikan') }}" required class="form-input rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
                            @error('jenis_ikan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                            <input type="number" name="berat" id="berat" value="{{ old('berat') }}" required class="form-input rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full" min="0" step="0.01">
                            @error('berat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="harga_awal" class="block text-sm font-medium text-gray-700">Harga Awal (Rp)</label>
                            <input type="number" name="harga_awal" id="harga_awal" value="{{ old('harga_awal') }}" required class="form-input rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full" min="0" step="0.01">
                            @error('harga_awal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="5" required class="form-textarea rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Simpan Produk') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>