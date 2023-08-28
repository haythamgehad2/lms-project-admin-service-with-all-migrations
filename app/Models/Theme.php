<?php

namespace App\Models;

use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Theme extends Model implements HasMedia
{

    use InteractsWithMedia,HasTranslations,HasFactory,UploadImageTrait;

    public const mediaCollectionName="themes";

    public $translatable = ['name','description'];

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Undocumented function
     *
     * @param Media $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('theme')->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_MAX,1000,1000)
            ->nonQueued();
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
     * ThemeImage function
     *
     * @return Attribute
     */
    public function themeImage() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl(self::mediaCollectionName, 'themes'):
                    ($this->image ? url($this->image) : url("storage/noimage.jpg"))
        );
    }
}
