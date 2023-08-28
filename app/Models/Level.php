<?php
namespace App\Models;
use App\Models\Scopes\UserLevelsScop;
use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Level extends Model implements HasMedia
{
    use InteractsWithMedia,HasTranslations,HasFactory;


    public $translatable = ['name'];


    protected $fillable = ['name','min_levels','school_id'];

     /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserLevelsScop);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Missions Level function
     *
     * @return hasMany
     */
    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class,'level_id')->whereNull('class_id')->withoutGlobalScopes();
    }



    /**
     * terms function
     *
     * @return belongsToMany
     */
    public function terms(): belongsToMany
    {
        return $this->belongsToMany(Term::class,'level_terms')->withoutGlobalScopes()->withTimestamps()->withPivot('id','school_id');
    }

    public function school_groups(): BelongsToMany
    {
        return $this->belongsToMany(SchoolGroup::class,'level_school_groups','level_id','school_group_id' )->withTimestamps();
    }

      /**

     * Undocumented function
     *
     * @param Media $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('level')->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_MAX,800,800)
            ->nonQueued();
    }

    /**
     * The roles that belong to the permission.
     */
    public function themes()
    {
        return $this->belongsToMany(Theme::class,'level_themes')->withTimestamps();
    }

     /**
     * The Level Has-Many Enrollments.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class,'level_id');
    }



}
