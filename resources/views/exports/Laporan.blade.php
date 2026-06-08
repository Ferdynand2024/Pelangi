<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Pemenang</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Harga Akhir</th>
            <th>Tanggal Selesai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produkList as $produk)
            @foreach($produk->penawaran as $penawaran)
                <tr>
                    <td>{{ $loop->parent->iteration }}</td>
                    <td>{{ $produk->jenis_ikan }}</td>
                    <td>{{ $penawaran->user->name ?? 'N/A' }}</td>
                    <td>{{ $penawaran->user->phone ?? '-' }}</td>
                    <td>{{ $penawaran->user->email ?? '-' }}</td>
                    <td>{{ $penawaran->user->alamat ?? '-' }}</td>
                    <td>Rp {{ number_format($penawaran->jumlah_penawaran, 0, ',', '.') }}</td>
                    <td>{{ $produk->waktu_selesai?->format('d-m-Y H:i') ?? '-' }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"><strong>Total Penjualan</strong></td>
            <td colspan="2"><strong>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></td>
        </tr>
    </tfoot>
</table>
