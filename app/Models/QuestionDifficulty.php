<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class QuestionDifficulty extends Model
{
    use HasTranslations, HasFactory;

    protected $fillable = [
        'name','slug','is_default','xp','coins', 'grade_points'
    ];

    public $translatable = ['name'];

    protected $casts = ['name' => "json"];

    /**
     * questions function
     *
     * @return HasMany
     */
    public function questions() :HasMany
    {
    return $this->HasMany(Question::class,'question_difficulty_id');
    }

}
