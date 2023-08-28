<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations,HasFactory;

    public $translatable = ['name'];

    protected $fillable = ['name','code'];

     /**
     * Get & Set the Country's name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {


        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            // set: fn ($value) => json_encode($value),
        );
    }

}
