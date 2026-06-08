<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark">
            {{ __('Laporan Lelang Selesai') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-4">
                        {{-- Form Filter: Tahun, Bulan, dan Tombol Cari --}}
                        <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
                            {{-- Select Tahun --}}
                            <div class="col-md-4">
                                <label for="year" class="form-label">Tahun:</label>
                                <select name="year" id="year" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor

                                </select>
                            </div>

                            {{-- Select Bulan --}}
                            <div class="col-md-4">
                                <label for="month" class="form-label">Bulan:</label>
                                <select name="month" id="month" class="form-select">
                                    <option value="">Semua Bulan</option>
                                    @php
                                    $months = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    @endphp
                                    @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ (int)request('month') === $num ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    Cari
                                </button>
                            </div>

                            <div class="mb-3 d-flex justify-content-end">
                                <a href="{{ route('laporan.export', request()->only(['year', 'month'])) }}" class="btn btn-success">
                                    <i class="bi bi-file-earmark-excel-fill me-1"></i> Export ke Excel
                                </a>
                            </div>

                        </form>
                    </div>

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