<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Penawaran') }}
        </h2>
    </x-slot>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                {{-- Kartu Riwayat Penawaran --}}
                <div class="card shadow rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h4 class="text-center">Riwayat Penawaran</h4>
                    </div>

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger m-3">{{ session('error') }}</div>
                    @endif

                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <ul class="list-group" id="riwayat-penawaran">
                            @forelse($produk->penawaran->sortByDesc('jumlah_penawaran') as $penawaran)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        Rp {{ number_format($penawaran->jumlah_penawaran, 0, ',', '.') }}<br>
                                        <small class="text-muted">{{ $penawaran->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge {{ $penawaran->user_id === Auth::id() ? 'bg-success' : 'bg-primary' }}"
                                          data-user-id="{{ $penawaran->user_id }}">
                                        {{ $penawaran->user->name }}
                                    </span>
                                </li>
                            @empty
                                <li class="list-group-item">Belum ada penawaran.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Tombol Kirim Notifikasi ke Penawar Kedua --}}
                @php
                    $pemenangUtama = $produk->penawaran->sortByDesc('jumlah_penawaran')->first();
                    $pemenangKedua = $produk->penawaran->sortByDesc('jumlah_penawaran')->skip(1)->first();
                @endphp

                @if(Auth::user()->role === 'tpi' && $pemenangUtama && $pemenangUtama->status === 'gugur' && $pemenangKedua)
                    <div class="text-center mt-4">
                        <form action="{{ route('produk.kirimNotifCadangan', $produk->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success rounded-4 px-4 py-2">
                                <i class="bi bi-whatsapp"></i> Kirim Notifikasi ke Penawar Kedua
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Tombol Kembali --}}
                <div class="text-center mt-3">
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary rounded-4 px-4 py-2">
                        ← Kembali ke Daftar Produk
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Style tambahan --}}
    <style>
        .badge {
            font-size: 13px;
            padding: 6px 10px;
            border-radius: 10px;
        }

        .btn-success i {
            margin-right: 5px;
        }

        .alert {
            border-radius: 12px;
        }
    </style>
</x-app-layout>
