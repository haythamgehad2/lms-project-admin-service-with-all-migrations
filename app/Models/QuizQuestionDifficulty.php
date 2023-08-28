<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionDifficulty extends Model
{
    use HasFactory;
    /**
     * fillable variable
     *
     * @var array
     */
    protected $fillable = ['quiz_id','question_difficulty_id','total_question'];
}
