<?php

namespace App\Models;

use App\Models\Scopes\UserClassScop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Classes extends Model implements HasMedia
{
    use InteractsWithMedia,HasTranslations,HasFactory;

    public $translatable = ['name'];

    protected $fillable = ['name','school_id','level_term_id'];
     /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserClassScop);
    }
    // /**
    //  * The terms that belong to the class.
    //  */
    // public function terms(): BelongsToMany
    // {
    //     return $this->belongsToMany(Term::class,'term_classes','class_id','term_id')->withTimestamps();;
    // }

    /**
     * The Level Term that belong to the class.
     */
    public function levelTerm(): BelongsTo
    {
        return $this->belongsTo(LevelTerm::class);
    }

     /**
     * The Level Term that belong to the class.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class,'class_id');
    }

    /**
     * Missions Level function
     *
     * @return hasMany
     */
    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class,'class_id')->where('is_selected',1);
    }
}
