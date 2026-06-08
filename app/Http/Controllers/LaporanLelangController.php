<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanLelangController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['penawaran.user'])
            ->whereNotNull('waktu_selesai');

        // Kombinasi filter tahun + bulan
        if ($request->filled('tahun') && $request->filled('bulan')) {
            $start = Carbon::create($request->tahun, $request->bulan, 1)->startOfMonth();
            $end   = Carbon::create($request->tahun, $request->bulan, 1)->endOfMonth();

            $query->whereBetween('waktu_selesai', [$start, $end]);
        } elseif ($request->filled('tahun')) {
            // hanya filter tahun
            $query->whereYear('waktu_selesai', $request->tahun);
        } elseif ($request->filled('bulan')) {
            // hanya filter bulan (semua tahun)
            $query->whereMonth('waktu_selesai', $request->bulan);
        }

        $produkList = $query->orderBy('waktu_selesai', 'desc')->get();

        // hanya produk dengan penawaran sudah bayar
        $produkList = $produkList->filter(function ($produk) {
            $produk->penawaran = $produk->penawaran->where('status', 'sudah');
            return $produk->penawaran->isNotEmpty();
        });

        $totalPenjualan = $produkList->reduce(function ($total, $produk) {
            return $total + $produk->penawaran->sum('jumlah_penawaran');
        }, 0);

        return view('laporan.laporan', compact('produkList', 'totalPenjualan'));
    }
    public function export(Request $request)
    {
        return Excel::download(
            new LaporanExport($request->tahun, $request->bulan),
            'laporan_lelang.xlsx'
        );
    }
}
