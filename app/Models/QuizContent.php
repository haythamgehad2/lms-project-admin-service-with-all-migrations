<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizContent extends Model
{
    use HasFactory;
    protected $table='quiz_contents';
    /**
     * fillable variable
     *
     * @var array
     */
    protected $fillable = ['question_id','quiz_id','order','is_selected'];


}
