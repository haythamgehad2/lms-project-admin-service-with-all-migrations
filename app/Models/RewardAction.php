<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardAction extends Model
{
    use HasFactory;

    public const start_video = "START_VIDEO_ACTION";
    public const complete_video = "COMPLETE_VIDEO_ACTION";
    public const finish_exam = "FINISH_EXAM_ACTION";
    public const paper_work_upload = "PAPER_WORK_UPLOAD";
    public const paper_work_download = "PAPER_WORK_DOWNLOAD";

    protected $fillable = [
        "action_name", "action_desc", "action_unique_name", "model_type", "max_trail",
        "jeel_coins","jeel_xp"
    ];

    public function scopeActionName(Builder $query, string $actionName) : Builder {
        return $query->where("action_unique_name", $actionName);
    }
}
