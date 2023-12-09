<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratIK extends Model
{
    use HasFactory;

    protected $table = 'izin_keluar';

    protected $fillable = [
        'rencana_berangkat',
        'rencana_kembali',
        'keperluan_ik',
        'mahasiswa_id',
        'status',
        'tanggal_approve'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
