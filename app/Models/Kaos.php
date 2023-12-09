<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaos extends Model
{
    use HasFactory;

    protected $fillable = [
        'ukuran',
        'kode_ukuran',
        'stok',
        'harga',
    ];
}
