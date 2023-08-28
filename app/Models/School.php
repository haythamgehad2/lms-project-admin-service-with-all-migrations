<?php

namespace App\Models;

use App\Models\Scopes\UserSchoolScop;
use App\Traits\UploadImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class School extends Model implements HasMedia
{
    use InteractsWithMedia,HasTranslations,HasFactory,UploadImageTrait;

    public $translatable = ['name'];


    public const mediaCollectionName="school_logo";

    protected $casts = [
        'subscription_start_date' => 'date:Y-m-d',
        'subscription_end_date' => 'date:Y-m-d',
    ];

    protected $fillable = ['name','school_group_id','status','music_status','admin_id','school_type_id','subscription_start_date','subscription_end_date','package_id','username','email'];


    /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserSchoolScop);
    }

    /**
     * schoolGroup function
     *
     * @return BelongsTo
     */
    public function schoolGroup(): BelongsTo
    {
        return $this->belongsTo(SchoolGroup::class);
    }

    /**
     * @return string
     */
    public function getSubscriptionStartDateAttribute($date)
    {
        return  Carbon::parse($date)->format('d-m-Y');
    }

    /**
     * @return string
     */
    public function getSubscriptionEndDateAttribute($date)
    {
        return  Carbon::parse($date)->format('d-m-Y');
    }

    /**
     * schoolType function
     *
     * @return BelongsTo
     */
    public function schoolType(): BelongsTo
    {
        return $this->belongsTo(SchoolType::class);
    }

    /**
     * package function
     *
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

     /**
     * Missions function
     *
     * @return HasMany
     */
    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class);
    }

    /**
     * Admin function
     *
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class,'admin_id');
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
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('school_logo')->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_MAX,1000,1000)
            ->nonQueued();
    }

    /**
     * UserImage function
     *
     * @return Attribute
     */
    public function logo() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl('school_logo', 'thumb'):
                    ($this->image ? url($this->image) : url("storage/noimage.jpg"))
        );
    }
}
