<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentActionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id", "reward_action_id", "model_type", "model_id", "jeel_coins", "jeel_xp",'mission_id'
    ];

    public function student() : BelongsTo {
        return $this->belongsTo(User::class, "student_id");
    }

    public function rewardAction() : BelongsTo {
        return $this->belongsTo(RewardAction::class, "reward_action_id");
    }

    public function scopeStudentId(Builder $query, int $studentId) : Builder {
        return $query->where("student_id", $studentId);
    }
}
