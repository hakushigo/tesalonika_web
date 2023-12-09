<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';
    protected $fillable = [
        'nim',
        'nama',
        'password',
        'login_token',
        'nomorHP',
        'nomorKTP'
    ];

    public function requests()
    {
        return $this->hasMany(RequestRuangan::class);
    }

    public function surat()
    {
        return $this->hasMany(RequestSurat::class);
    }

    public function suratIk()
    {
        return $this->hasMany(SuratIK::class);
    }

    public function izinBermalam(){
        return $this->hasMany(IzinBermalam::class);
    }
}
