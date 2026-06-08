<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Bukti Pembayaran Lelang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            height: 100px;
            /* Ukuran logo diperbesar */
            margin-bottom: 10px;
        }

        h2 {
            color: #005f73;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #005f73;
            color: white;
            text-align: left;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }

    </style>
</head>
<body>
    <div class="header">
        <img src="assets/img/logo.jpg" alt="Logo" class="logo" />
        <h2>Bukti Pembayaran Lelang</h2>
    </div>

    <p>Terima kasih telah melakukan pembayaran. Berikut adalah detail transaksi Anda:</p>
    <table>
        <tr>
            <th>ID Transaksi</th>
            <td>{{ $orderId }}</td>
        </tr>
        <tr>
            <th>Nama Pembeli</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email Pembeli</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Nama TPI</th>
            <td>{{ $tpi->name ?? 'Tidak tersedia' }}</td>
        </tr>
        <tr>
            <th>Email TPI</th>
            <td>{{ $tpi->email ?? '-' }}</td>
        </tr>

        <tr>
            <th>Jenis Ikan</th>
            <td>{{ $produk->jenis_ikan }}</td>
        </tr>
        <tr>
            <th>Harga Penawaran</th>
            <td>Rp {{ number_format($pemenang->jumlah_penawaran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Status Pembayaran</th>
            <td>Sukses </td>
        </tr>
        <tr>
            <th>Tanggal Pembayaran</th>
            <td>{{ \Carbon\Carbon::parse($tanggalPembayaran)->format('d M Y, H:i') }}</td>
        </tr>
    </table>


    <div class="footer">
        &copy; {{ date('Y') }} Sistem Lelang Ikan. Semua hak dilindungi.
    </div>
</body>
</html>
