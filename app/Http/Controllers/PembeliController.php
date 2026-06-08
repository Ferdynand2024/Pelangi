<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import model User
use Illuminate\View\View; // Import untuk type hinting

class PembeliController extends Controller
{
    /**
     * Menampilkan daftar pembeli dari tabel users.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $pembeli = User::where('role', 'pembeli')->get(); // Ambil semua user dengan role 'pembeli'
        return view('pembeli.index', compact('pembeli')); // Kirim data pembeli ke view
    }
}
