<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class QuestionType extends Model
{

    use HasTranslations,HasFactory;

    /**
     * translatable variable
     *
     * @var array
     */
    public $translatable = ['name'];

    /**
     * fillable variable
     *
     * @var array
     */
    protected $fillable = ['name','slug','is_default','parent_id'];

    /**
     * parent function
     *
     * @return BelongsTo
     */
    public function parent() :BelongsTo
    {
    return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * children function
     *
     * @return HasMany
     */
      public function children():HasMany
      {
        return $this->hasMany(static::class, 'parent_id');
      }

      /**
       * Subs function
       *
       * @return array
       */
      public function subs()
      {
          return $this->children()->with(['subs']);
      }

}
