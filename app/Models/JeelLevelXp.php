<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JeelLevelXp extends Model
{
    use HasFactory;

    protected $fillable = [
        "level", "xp"
    ];
}
