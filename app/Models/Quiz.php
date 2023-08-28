<?php

namespace App\Models;

use App\Enums\QuestionDifficultyTypes;
use App\Enums\QuizTypesEnum;
use App\Models\Scopes\UserQuizScop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use stdClass;

class Quiz extends Model
{
    use HasFactory,HasTranslations;

    /**
     * translatable variable
     *
     * @var array
     */
    public $translatable = ['name','description'];
    /**
     * fillable variable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'total_question', 'type', 'level_id','term_id', 'learning_path_id',
        'school_id', 'order', 'is_selected', 'total_grade', 'success_grade', 'calc_type',
        "total_grade_points", "easy_grade_point", "medium_grade_point", "hard_grade_point",
    ];

     /**
     * Casts variable
     *
     * @var array
     */
    protected $casts = [
        // 'type' => QuizTypesEnum::class,
    ];


     /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserQuizScop);
    }
    /**
     * parent function
     *
     * @return BelongsTo
     */
    public function level():BelongsTo
    {
    return $this->belongsTo(Level::class);

    }

    /**
     * level Relationship Function
     *
     * @return BelongsTo
     */
    public function term(): BelongsTo
    {
        return $this->BelongsTo(Term::class);
    }
    /**
     * Learning Path function
     *
     * @return BelongsTo
     */
    public function learningPath():BelongsTo
    {
       return $this->belongsTo(LearningPath::class);
    }

     /**
 * Questions Difficulties function
     *
     * @return BelongsTo
     */
    public function questionsDifficulties():BelongsToMany
    {
       return $this->belongsToMany(QuestionDifficulty::class,'quiz_question_difficulties')->withPivot('total_question')->withTimestamps();

    }

    /**
     * Questions function
     *
     * @return belongsToMany
     */
    public function questions():belongsToMany
    {
       return $this->belongsToMany(Question::class,'quiz_contents')->withPivot('question_id','order','is_selected')->withTimestamps();
    }

    /**
     * Quiz Questions function
     *
     * @return BelongsTo
     */
    public function quizQuestions():BelongsToMany
    {
       return $this->belongsToMany(QuizContent::class,'quiz_contents','quiz_id','question_id')->withTimestamps();

    }

    public function updateGradPoints() {
        $quiz = $this->load("questions.questionDifficulty");
        $points = new stdClass;
        $points->total_grade_points = 0;
        $points->easy_grade_point = 0;
        $points->medium_grade_point = 0;
        $points->hard_grade_point = 0;

        $quiz->questions->each(function (Question $question) use (&$points) {
            $points->total_grade_points += $question->questionDifficulty->grade_points ?? 0;
            switch($question->questionDifficulty->slug ?? "") {
                case QuestionDifficultyTypes::easy:
                    $points->easy_grade_point = $question->questionDifficulty->grade_points;
                    break;
                case QuestionDifficultyTypes::medium:
                    $points->medium_grade_point = $question->questionDifficulty->grade_points;
                    break;
                case QuestionDifficultyTypes::hard:
                    $points->hard_grade_point = $question->questionDifficulty->grade_points;
                    break;
            }
        });

        $quiz->update([
            "total_grade_points" => $points->total_grade_points,
            "easy_grade_point" => $points->easy_grade_point,
            "medium_grade_point" => $points->medium_grade_point,
            "hard_grade_point" => $points->hard_grade_point,
        ]);
    }
}
