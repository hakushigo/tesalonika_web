<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRuangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'mahasiswa',
        'ruangan_id',
        'tanggal_terima',
        'status',
        'keterangan',
        'end_time',
        'start_time'
    ];

    protected $table = "request_ruangan";

    // Relationship dengan Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relationship dengan Ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
