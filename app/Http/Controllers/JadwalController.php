<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * Display a listing of the jadwal.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Tetapkan waktu batas, 60 menit yang lalu dari waktu sekarang.
        $cutoffTime = Carbon::now()->subMinutes(1);

        // Cari dan hapus semua jadwal yang sudah lewat dari batas waktu.
        Jadwal::whereRaw("CONCAT(tanggal_lelang, ' ', waktu_mulai) < ?", [$cutoffTime->toDateTimeString()])
            ->delete();

        // Ambil semua data jadwal yang tersisa (sudah bersih).
        $jadwals = Jadwal::all();

        return view('jadwal.index', compact('jadwals'));
    }


    /**
     * Show the form for creating a new jadwal.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jadwal.create');
    }

    /**
     * Store a newly created jadwal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Tambahkan detik jika format waktu hanya HH:MM
        if (Str::contains($request->waktu_mulai, ':') && Str::substrCount($request->waktu_mulai, ':') === 1) {
            $request->merge(['waktu_mulai' => $request->waktu_mulai . ':00']);
        }

        // --- LOGIKA CEK MASA LALU ---
        $dateTimeString = $request->tanggal_lelang . ' ' . $request->waktu_mulai;

        try {
            $jadwalWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeString);
        } catch (\InvalidArgumentException $e) {
            $jadwalWaktu = null;
        }

        if ($jadwalWaktu && $jadwalWaktu->isPast()) {
            return redirect()->back()
                ->withErrors(['tanggal_lelang' => 'Jadwal lelang tidak bisa dibuat di masa lalu atau sudah lewat'])
                ->withInput();
        }
        // --- AKHIR LOGIKA CEK MASA LALU ---

        $request->validate([
            // ATURAN DIPERBARUI: Sekarang mengizinkan huruf (a-zA-Z), angka (0-9), dan spasi.
            'nama_barang' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9 ]+$/u'],
            'tanggal_lelang' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i:s',
            // ATURAN DIPERBARUI: Sekarang mengizinkan huruf (a-zA-Z), angka (0-9), dan spasi.
            'lokasi' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9 ]+$/u'],
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal lelang berhasil ditambahkan.');
    }

    /**
     * Display the specified jadwal.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show(Jadwal $jadwal)
    {
        return view('jadwal.show', compact('jadwal'));
    }

    /**
     * Show the form for editing the specified jadwal.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit(Jadwal $jadwal)
    {
        return view('jadwal.edit', compact('jadwal'));
    }

    /**
     * Update the specified jadwal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        // Tambahkan detik jika format waktu hanya HH:MM
        if (Str::contains($request->waktu_mulai, ':') && Str::substrCount($request->waktu_mulai, ':') === 1) {
            $request->merge(['waktu_mulai' => $request->waktu_mulai . ':00']);
        }

        // --- LOGIKA CEK MASA LALU UNTUK UPDATE ---
        $dateTimeString = $request->tanggal_lelang . ' ' . $request->waktu_mulai;
        try {
            $jadwalWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeString);
        } catch (\InvalidArgumentException $e) {
            $jadwalWaktu = null;
        }

        if ($jadwalWaktu && $jadwalWaktu->isPast()) {
            return redirect()->back()
                ->withErrors(['tanggal_lelang' => 'Jadwal lelang tidak bisa diperbarui ke waktu di masa lalu atau sudah lewat'])
                ->withInput();
        }
        // --- AKHIR LOGIKA CEK MASA LALU UNTUK UPDATE ---

        $request->validate([
            // ATURAN DIPERBARUI: Sekarang mengizinkan huruf (a-zA-Z), angka (0-9), dan spasi.
            'nama_barang' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9 ]+$/u'],
            'tanggal_lelang' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i:s',
            // ATURAN DIPERBARUI: Sekarang mengizinkan huruf (a-zA-Z), angka (0-9), dan spasi.
            'lokasi' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9 ]+$/u'],
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal lelang berhasil diperbarui.');
    }

    /**
     * Remove the specified jadwal from storage.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal lelang berhasil dihapus.');
    }
}
