<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VimeoVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "vimeo_video_id", "video_bank_id", "is_fully_uploaded",
        "vimeo_response", "vimeo_private_link", "upload_error",
        "is_replaced", "has_music",
    ];

    protected $casts = [
        "vimeo_response" => "json",
        "is_fully_uploaded" => "boolean",
        "is_replaced" => "boolean",
        "has_music" => "boolean",
    ];

    public function video() : BelongsTo {
        return $this->belongsTo(VideoBank::class, "video_bank_id");
    }

    public function scopeNotFullUploaded(Builder $query) : Builder {
        return $query->where("is_fully_uploaded", false);
    }
}
