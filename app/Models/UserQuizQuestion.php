<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserQuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_quiz_id', 'question_id', 'attempts', 'correct',
    ];

    public function userQuiz() : BelongsTo {
        return $this->belongsTo(UserQuiz::class, "user_quiz_id");
    }

    public function question() : BelongsTo {
        return $this->belongsTo(Question::class, "question_id");
    }

    public function userQuizAnswers() : HasMany {
        return $this->hasMany(UserQuizAnswer::class, "user_quiz_question_id");
    }
}
