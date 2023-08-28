<?php
namespace App\Models;
use App\Enums\SchoolGroupTypeEnum;
use App\Models\Scopes\UserSchoolGroupScop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Translatable\HasTranslations;

class SchoolGroup extends Model
{
    use HasTranslations,HasFactory;

    public $translatable = ['name'];

    protected $fillable = ['name','country_id','status','type','music_status','owner_id','username','useremail'];

     /**
     * Globale Scope function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserSchoolGroupScop);
    }
     /**
     * parent function
     *
     * @return HasMany
     */
    public function schools() :HasMany
    {
        return $this->HasMany(School::class,'school_group_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id');
    }
    /**
     * levels function
     *
     * @return BelongsToMany
     */
    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class,'level_school_groups','school_group_id' ,'level_id')->withoutGlobalScopes()->withTimestamps();
    }
}
