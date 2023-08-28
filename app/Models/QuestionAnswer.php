<?php

namespace App\Models;

use App\Traits\UploadAudioTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class QuestionAnswer extends Model implements HasMedia
{
    use InteractsWithMedia,HasTranslations,HasFactory,UploadAudioTrait,UploadImageTrait;

    public const mediaCollectionName="question_answer";
    /**
     * translatable variable
     *
     * @var array
     */
    public $translatable = ['answer'];
    /**
     * fillable variable
     *
     * @var array
     */
    protected $fillable = ['answer','question_id','correct','answer_audio','correct_answers','match_to','match_from','order'];

    /**
     * parent function
     *
     * @return BelongsTo
     */
    public function question() :BelongsTo
    {
        return $this->belongsTo(Question::class);
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
        $this->addMediaConversion('question_answer')->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_MAX,1000,1000)
            ->nonQueued();
    }

    /**
     * UserImage function
     *
     * @return Attribute
     */
    public function questionAnswerImage() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl('question_answer', 'thumb'):
                    ($this->image ? url($this->image) : url("storage/noimage.jpg"))
        );
    }

}
