<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    // App\Models\Pembayaran.php
    protected $fillable = [
        'user_id',
        'produk_id',
        'order_id',
        'payment_type',
        'transaction_status',
        'transaction_time',
        'gross_amount',
        'status',
    ];
}
