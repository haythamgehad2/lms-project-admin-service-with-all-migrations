<?php

namespace App\Models;

use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\File;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class VideoBank extends Model implements HasMedia
{
    use InteractsWithMedia,HasFactory,HasTranslations,UploadImageTrait;

    public const mediaCollectionName="thumbnail";

    /**
     * translatable variable
     *
     * @var array
     */
    public $translatable = ['title','description'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'original_name',
        'disk',
        'path',
        'stream_path',
        'order',
        'processed',
        'converted_for_streaming_at',
        'learning_path_id',
        'level_id',
        'term_id',
        'video_without_music_disk',
        'video_without_music_path',
    ];


    /**
     * LearningPath function
     *
     * @return BelongsTo
     */
    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
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
     * level Relationship Function
     *
     * @return BelongsTo
     */
    public function term(): BelongsTo
    {
        return $this->BelongsTo(Term::class);
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

    public function videoFullUrl() : Attribute {
        return Attribute::make(
            get: fn() => $this->path && $this->disk ?  env('BASE_URL','https://jeeladmin.suredemos.com/').$this->disk.'/'.$this->path : null
        );
    }

    public function videoSizeBytes() : Attribute {
        return Attribute::make(
            get: fn() => $this->path && $this->disk ? File::size(public_path("{$this->disk}/{$this->path}")) : null
        );
    }

    public function videoWithoutMusicFullUrl() : Attribute {
        return Attribute::make(
            get: fn() => $this->video_without_music_disk && $this->video_without_music_path ?
                env('BASE_URL','https://jeeladmin.suredemos.com/').$this->video_without_music_disk.'/'.$this->video_without_music_path : null
        );
    }

    public function videoWithoutMusicSizeBytes() : Attribute {
        return Attribute::make(
            get: fn() => $this->video_without_music_disk && $this->video_without_music_path ?
                File::size(public_path("{$this->video_without_music_disk}/{$this->video_without_music_path}")) : null
        );
    }

    public function videoFullPath() : Attribute {
        return Attribute::make(
            get: fn() => $this->path && $this->disk ? public_path("{$this->disk}/{$this->path}") : null
        );
    }

    public function firstVimeo() : HasOne {
        return $this->hasOne(VimeoVideo::class, "video_bank_id")->where("has_music", true);
    }

    public function vimeo() : HasOne {
        return $this->hasOne(VimeoVideo::class, "video_bank_id")->where("is_replaced", false)->where("has_music", true);
    }

    public function allVimeo() : HasMany {
        return $this->hasMany(VimeoVideo::class, "video_bank_id")->where("has_music", true);
    }

    public function firstVimeoWithoutMusic() : HasOne {
        return $this->hasOne(VimeoVideo::class, "video_bank_id")->where("has_music", false);
    }

    public function vimeoWithoutMusic() : HasOne {
        return $this->hasOne(VimeoVideo::class, "video_bank_id")->where("is_replaced", false)->where("has_music", false);
    }

    public function allVimeoWithoutMusic() : HasMany {
        return $this->hasMany(VimeoVideo::class, "video_bank_id")->where("has_music", false);
    }
}
