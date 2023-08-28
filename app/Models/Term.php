<?php

namespace App\Models;

use App\Models\Scopes\UserTermScop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Term extends Model implements HasMedia
{
    use InteractsWithMedia,HasTranslations,HasFactory;

    public $translatable = ['name'];



    /**
     * Fillable variable
     *
     * @var array
     */
    protected $fillable = ['name','school_id'];


     /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserTermScop);
    }
    /**
     * The roles that belong to the permission.
     */
    public function levels()
    {
        return $this->belongsToMany(Level::class,'level_terms','term_id','level_id')->withoutGlobalScopes()->withPivot('school_id')->withTimestamps();
    }

    /**
     * The Term that belong to the School.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
