<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinBermalam extends Model
{
    use HasFactory;

    protected $table = 'izin_bermalam';

    protected $fillable = [
        'tanggal_berangkat',
        'tanggal_kembali',
        'keperluan_ib',
        'tempat_tujuan',
        'mahasiswa',
        'status',
        'tanggal_approve'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}


