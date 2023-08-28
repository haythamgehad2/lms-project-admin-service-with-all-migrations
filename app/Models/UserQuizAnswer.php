<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_quiz_id", "user_quiz_question_id", "answer_id"
    ];

    public function userQuiz() : BelongsTo {
        return $this->belongsTo(UserQuiz::class, "user_quiz_id");
    }

    public function answer() : BelongsTo {
        return $this->belongsTo(QuestionAnswer::class, "answer_id");
    }

    public function userQuizQuestion() : BelongsTo {
        return $this->belongsTo(UserQuizQuestion::class, "user_quiz_question_id");
    }
}
