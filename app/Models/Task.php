<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Task extends Model
{
    use HasFactory,HasTranslations;

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
    protected $fillable = ['name','description','level_id'];



      /**
     * parent function
     *
     * @return BelongsTo
     */
    public function level() :BelongsTo
    {
    return $this->belongsTo(Level::class);

    }
}
