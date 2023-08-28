<?php

namespace App\Models;

use App\Enums\PeperworkTypeEnum;
use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class PeperWork extends Model implements HasMedia
{
    use InteractsWithMedia,HasTranslations,HasFactory,UploadImageTrait;


    public const mediaCollectionName="thumbnail";

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
    protected $fillable = ['name','description','type','level_id','term_id','learning_path_id','path','disk','original_name',
    'paper_work_without_color_disk','paper_work_without_color_path','paper_work_final_degree'];

    /**
     * Casts variable
     *
     * @var array
     */
    protected $casts = [
        'type' => PeperworkTypeEnum::class,
    ];

    /**
     * parent function
     *
     * @return BelongsTo
     */
    public function level() :BelongsTo
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
     * parent function
     *
     * @return BelongsTo
     */
    public function learningPath() :BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
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
        $this->addMediaConversion('thumbnail')->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_MAX,1000,1000)
            ->nonQueued();
    }

    // /**
    //  * UserImage function
    //  *
    //  * @return Attribute
    //  */
    // public function file() : Attribute {
    //     return Attribute::make(
    //         get: fn($value) =>
    //             $this?->media?->first() ?
    //                 $this->getFirstMediaUrl('peapr_work', 'thumb'):
    //                 ($this->image ? url($this->image) : url("storage/noimage.jpg"))
    //     );
    // }

    /**
     * UserImage function
     *
     * @return Attribute
     */
    public function thumbnail() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl('thumbnail', 'thumb'):
                    ($this->image ? url($this->image) : url("storage/noimage.jpg"))
        );
    }

    public function paperWorkFullUrl() : Attribute {
        return Attribute::make(
            get: fn() => $this->path && $this->disk ? env('BASE_URL','https://jeeladmin.suredemos.com/').$this->disk.'/'.$this->path : null
        );
    }

    public function paperWorkSizeBytes() : Attribute {
        return Attribute::make(
            get: fn() => $this->path && $this->disk ? File::size(public_path("{$this->disk}/{$this->path}")) : null
        );
    }

    public function paperWorkWithoutColorFullUrl() : Attribute {
        return Attribute::make(
            get: fn() => $this->paper_work_without_color_disk && $this->paper_work_without_color_path ?
            env('BASE_URL','https://jeeladmin.suredemos.com/').$this->paper_work_without_color_disk.'/'.$this->paper_work_without_color_path : null
        );
    }

    public function paperWorkWithoutColorSizeBytes() : Attribute {
        return Attribute::make(
            get: fn() => $this->paper_work_without_color_disk && $this->paper_work_without_color_path ?
                File::size(public_path("{$this->paper_work_without_color_disk}/{$this->paper_work_without_color_path}")) : null
        );
    }

    public function paperWorkFullPath() : Attribute {
        return Attribute::make(
            get: fn() => $this->path && $this->disk ? public_path("{$this->disk}/{$this->path}") : null
        );
    }

}
