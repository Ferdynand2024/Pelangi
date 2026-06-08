<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Produk;

class LaporanExport implements FromView, WithEvents
{
    protected $year;
    protected $month;

    public function __construct($year = null, $month = null)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function view(): View
    {
        $query = Produk::with(['penawaran.user'])
            ->whereNotNull('waktu_selesai');

        if ($this->year) {
            $query->whereYear('waktu_selesai', $this->year);
        }

        if ($this->month) {
            $query->whereMonth('waktu_selesai', $this->month);
        }

        $produkList = $query->get();

        // Filter hanya penawaran yang sudah bayar
        $produkList = $produkList->filter(function ($produk) {
            $produk->penawaran = $produk->penawaran->where('status', 'sudah');
            return $produk->penawaran->isNotEmpty();
        });

        $totalPenjualan = $produkList->reduce(function ($total, $produk) {
            return $total + $produk->penawaran->sum('jumlah_penawaran');
        }, 0);

        return view('exports.Laporan', compact('produkList', 'totalPenjualan'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                // Header styling (baris pertama)
                $sheet->getStyle('A1:' . $highestCol . '1')->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'color' => ['rgb' => '4F81BD'] // biru
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ]
                ]);

                // Border untuk semua sel
                $sheet->getStyle('A1:' . $highestCol . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Auto-size semua kolom
                foreach (range('A', $highestCol) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
