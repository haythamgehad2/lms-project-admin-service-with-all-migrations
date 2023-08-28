<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BloomCategory extends Model
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
    protected $fillable = ['name','slug','is_default'];
}
