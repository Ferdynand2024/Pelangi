<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [ // kolom yang boleh diisi
        'foto',
        'jenis_ikan',
        'berat',
        'harga_awal',
        'deskripsi',
        'status_lelang',
        'waktu_mulai',
        'waktu_selesai',
        'pemenang_lelang_id',
        'harga_akhir',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'waktu_gugur_pemenang1' => 'datetime',
        // tambahkan kolom tanggal lain jika ada
    ];

    public function penawaran()
    {
        return $this->hasMany(Penawaran::class);
    }
    // app/Models/Produk.php

    public function pemenangLelang()
    {
        return $this->belongsTo(User::class, 'pemenang_lelang_id');
    }

    // App/Models/Produk.php
    public function pemenangCadangan()
    {
        return $this->belongsTo(User::class, 'pemenang_cadangan_id');
    }
    
}
