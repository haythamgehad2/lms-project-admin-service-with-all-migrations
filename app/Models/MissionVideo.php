<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionVideo extends Model
{
    use HasFactory;

    /**
     * Belonsto function
     *
     * @return void
     */
    public function videos():BelongsTo
    {
        return $this->belongsTo(VideoBank::class,'video_bank_id');
    }
}
