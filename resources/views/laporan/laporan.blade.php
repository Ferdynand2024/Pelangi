<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Lelang') }}
        </h2>
    </x-slot>

    <div class="py-4 px-3 px-md-4">
        <div class="container" style="max-width: 1140px;">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET">
                        <div class="row gy-3 align-items-end">
                            <div class="col-12 col-md-4">
                                <label for="tahun" class="form-label">Tahun:</label>
                                <select name="tahun" id="tahun" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>

                            </div>

                            <div class="col-12 col-md-4">
                                <label for="bulan" class="form-label">Bulan:</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="">Semua Bulan</option>
                                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $index => $bulan)
                                    <option value="{{ $index+1 }}" {{ request('bulan') == $index+1 ? 'selected' : '' }}>{{ $bulan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4 d-flex flex-column flex-md-row gap-2">
                                <button type="submit" class="btn btn-primary w-100">Cari</button>

                                {{-- Sertakan filter saat export --}}
                                <a href="{{ route('laporan.export', request()->only(['tahun','bulan'])) }}" class="btn btn-success w-100">
                                    Export ke Excel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    @if($produkList->isEmpty())
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>Belum ada data lelang yang selesai sesuai kriteria filter.</div>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Pemenang</th>
                                    <th>Harga Akhir</th>
                                    <th>Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produkList as $produk)
                                @php
                                $pemenangs = $produk->penawaran->where('status', 'sudah');
                                @endphp

                                @foreach ($pemenangs as $pemenang)
                                <tr>
                                    <td>{{ $loop->parent->iteration }}</td>
                                    <td>{{ $produk->jenis_ikan }}</td>
                                    <td>{{ $pemenang->user->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($pemenang->jumlah_penawaran, 0, ',', '.') }}</td>
                                    <td>{{ $produk->waktu_selesai->format('d M Y H:i') }}</td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total Penjualan:</th>
                                    <th colspan="2">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>