<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class api_access extends Model
{
    use HasFactory;

    protected $table = "api_credentials";
    protected $fillable = [
        "api_name",
        "api_key",
        "valid_until"
    ];
}
