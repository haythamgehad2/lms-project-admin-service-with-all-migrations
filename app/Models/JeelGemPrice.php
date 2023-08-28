<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JeelGemPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        "quantity", "jeel_coins_quantity"
    ];
}
