<?php
namespace App\Models;

use App\Traits\UploadAudioTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Question extends Model
{
    use HasTranslations,HasFactory,UploadAudioTrait;

    /**
     * translatable variable
     *
     * @var array
     */
    public $translatable = ['question','hint'];

    /**
     * fillable variable
     *
     * @var array
     */
    protected $fillable = ['question','question_audio','question_type_id','language_skill_id','bloom_category_id','language_method_id','question_type_sub_id','learning_path_id','question_difficulty_id','hint','question_pattern','level_id'];

    /**
     * Answers Relationship Function
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class,'question_id');
    }

    /**
     * quizzes Relationship Function
     *
     * @return belongsToMany
     */
    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class,'quiz_contents','question_id','quiz_id')->withTimestamps();
    }

     /**
     * level Relationship Function
     *
     * @return BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->BelongsTo(Level::class);
    }
    /**
     * learningPath Relationship Function
     *
     * @return BelongsTo
     */
    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }
    /**
     * questionType Relationship Function
     *
     * @return BelongsTo
     */
    public function questionType(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class,'question_type_id');
    }

    /**
     * subQuestionType Relationship Function
     *
     * @return BelongsTo
     */
    public function subQuestionType(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class,'question_type_sub_id');
    }
    /**
     * Answers Relationship Function
     *
     * @return BelongsTo
     */
    public function questionDifficulty(): BelongsTo
    {
        return $this->belongsTo(QuestionDifficulty::class);
    }

     /**
     * LanguageSkill Relationship Function
     *
     * @return BelongsTo
     */
    public function languageSkill(): BelongsTo
    {
        return $this->belongsTo(LanguageSkill::class);
    }

    /**
     * LanguageMethod Relationship Function
     *
     * @return BelongsTo
     */
    public function languageMethod(): BelongsTo
    {
        return $this->belongsTo(LanguageMethod::class);
    }


      /**
     * LanguageMethod Relationship Function
     *
     * @return BelongsTo
     */
    public function quesitonParent(): BelongsTo
    {
        return $this->belongsTo(LanguageMethod::class);
    }
    /**
     * BloomCategory Relationship Function
     *
     * @return BelongsTo
     */
    public function bloomCategory(): BelongsTo
    {
        return $this->belongsTo(BloomCategory::class);
    }

    //    /**
    //  * ThemeImage function
    //  *
    //  * @return Attribute
    //  */
    // public function questionAudio() : Attribute {
    //     return Attribute::make(
    //         get: fn($value) =>$this->question_audio ? env('APP_URL').$this->question_audio :null
    //     );
    // }

}
