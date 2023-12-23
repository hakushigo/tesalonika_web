<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BAAK extends Model
{
    use HasFactory;

    protected $table = "baak";
    protected $fillable = [
        "username", "password", "login_token"
    ];
}
