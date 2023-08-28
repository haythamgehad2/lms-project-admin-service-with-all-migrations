<?php

namespace App\Models;

use App\Models\Scopes\UserSchoolTypeScop;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations;

class SchoolType extends Model
{
    use HasTranslations,HasFactory;

    public $translatable = ['name'];

    protected $fillable = ['name'];

     /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserSchoolTypeScop);
    }
     /**
     * parent function
     *
     * @return HasMany
     */
    public function schools() :HasMany
    {
        return $this->HasMany(School::class,'school_type_id');
    }

}
