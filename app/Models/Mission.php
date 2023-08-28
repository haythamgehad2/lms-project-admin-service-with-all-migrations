<?php
namespace App\Models;
use App\Models\Scopes\UserMissionScop;
use App\Traits\UploadImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Video;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
class Mission extends Model implements HasMedia
{
    public const mediaCollectionName="mission_image";

    use InteractsWithMedia,HasTranslations,HasFactory,UploadImageTrait;
    /**
     * translatable variable
     *
     * @var array
     */
    public $translatable = ['name','description'];

    /**
     * $fillable variable
     *
     * @var array
     */
    protected $fillable = ['name','description','data_range','country_id','level_id','term_id','is_selected','total_xp','total_jc',
    'order','start_date','end_date','original_id','class_id'];


      /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserMissionScop);
    }
     /**
     * The LearningPath that belong to many the Mission.
     */
    public function learningPaths(): BelongsToMany
    {
        return $this->belongsToMany(LearningPath::class,'mission_learningpaths')->withPivot('learning_path_id','total_xp','total_jc','is_selected')->withTimestamps();
    }


      /**
     * The Videos that belong to Many the Mission.
     */
    public function learningPathVideos(): BelongsToMany
    {
        return $this->belongsToMany(LearningPath::class,'mission_videos')->withPivot('video_bank_id','is_selected','order')->withTimestamps();
    }
     /**
     * The PapersWork that belong to Many the Mission.
     */
    public function learningPathPapersWorks(): BelongsToMany
    {
        return $this->belongsToMany(LearningPath::class,'mission_paper_works')->withPivot('peper_work_id','order','is_selected')->withTimestamps();
    }

    /**
     * The PapersWork that belong to Many the Mission.
     */
    public function learningPathQuizzes(): BelongsToMany
    {
        return $this->belongsToMany(LearningPath::class,'mission_quizzes')->withPivot('quiz_id','order','is_selected')->withTimestamps();
    }


     /**
     * The Videos that belong to Many the Mission.
     */
    public function videosBanks(): BelongsToMany
    {
        return $this->belongsToMany(VideoBank::class,'mission_videos')->withPivot('learning_path_id','is_selected','order')->withTimestamps();
    }
     /**
     * The PapersWork that belong to Many the Mission.
     */
    public function papersWork(): BelongsToMany
    {
        return $this->belongsToMany(PeperWork::class,'mission_paper_works')->withPivot('learning_path_id','order','is_selected')->withTimestamps();
    }

    /**
     * The Quizzes that belong to Many the Mission.
     */
    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class,'mission_quizzes')->withPivot('learning_path_id','order','is_selected')->withTimestamps();
    }

     /**
     * The Country that belong to the Mission.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class)->withoutGlobalScopes();
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class)->withoutGlobalScopes();
    }

    public function orginalMission(): BelongsTo
    {
        return $this->belongsTo(Mission::class,'original_id')->withoutGlobalScopes();
    }

     /**
     * ThemeImage function
     *
     * @return Attribute
     */
    public function mediaCollectionName() : Attribute {
        return Attribute::make(
            get: fn() => self::mediaCollectionName,
        );
    }
    /**
     * Undocumented function
     *
     * @param Media $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('mission_image')->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_MAX,250,250)
            ->nonQueued();
    }
    /**
     * ThemeImage function
     *
     * @return Attribute
     */
    public function missionImage() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl('mission_image', 'themes'):
                    ($this->image ? url($this->image) : url("storage/noimage.jpg"))
        );
    }

}


