<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations;

class Permission extends Model
{
    use HasTranslations,HasFactory;

    public $translatable = ['name'];
    protected $fillable = ['name','code'];


        /**
     * The roles that belong to the permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

}
