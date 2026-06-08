<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use App\Models\User; // Pastikan ini tetap ada jika digunakan di bagian lain
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = Produk::with('pemenangLelang')
    //         ->withMax('penawaran', 'jumlah_penawaran')
    //         ->where('status_lelang', 'ditutup')
    //         ->whereNotNull('pemenang_lelang_id');

    //     if ($request->filled('year')) {
    //         $query->whereYear('waktu_selesai', $request->input('year'));
    //     }

    //     if ($request->filled('month')) {
    //         $query->whereMonth('waktu_selesai', $request->input('month'));
    //     }

    //     $laporanPembayaran = $query->get();
    //     $totalPenjualan = $laporanPembayaran->sum('harga_akhir');
    //     $startYear = 2025;
    //     $endYear = 2040;
    //     $availableYears = range($startYear, $endYear);

    //     return view('laporan.index', compact('laporanPembayaran', 'availableYears', 'totalPenjualan'));
    // }

    public function laporan($id)
    {
        $produk = Produk::with(['penawaran.user'])->findOrFail($id);

        // Ambil penawaran dan tentukan pemenang
        $penawaran = $produk->penawaran->sortByDesc('jumlah_penawaran');
        $pemenang = $penawaran->first();

        return view('laporan.laporan', compact('produk', 'penawaran', 'pemenang'));
    }


    public function export(Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        return Excel::download(new LaporanExport($year, $month), 'laporan_lelang.xlsx');
    }
}
