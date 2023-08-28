<?php

namespace App\Models;

use App\Models\Scopes\UserPackagesScop;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use HasTranslations,HasFactory;

    public $translatable = ['name','description'];

    protected $fillable = ['name','description','price','classes_count'];


      /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserPackagesScop);
    }
     /**
     * parent function
     *
     * @return HasMany
     */
    public function schools() :HasMany
    {
        return $this->HasMany(School::class,'package_id');
    }

    public function getDynamicLocale()
    {
        return App::getLocale();
    }
}
