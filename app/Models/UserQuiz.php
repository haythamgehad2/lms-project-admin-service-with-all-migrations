<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'quiz_id', 'start_solving', 'finish_solving', 'grade', 'answered_grade_points'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz() : BelongsTo {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function userQuizQuestions() : HasMany {
        return $this->hasMany(UserQuizQuestion::class, "user_quiz_id");
    }
}
