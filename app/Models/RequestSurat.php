<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSurat extends Model
{
    protected $table = 'request_surat';

    protected $fillable = [
        'keperluansurat',
        'deskripsi',
        'tanggal_pengajuan',
        'tanggal_pengambilan',
        'mahasiswa_id',
        'status',
        'tanggal_approve',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
