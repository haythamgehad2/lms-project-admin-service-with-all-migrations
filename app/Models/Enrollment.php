<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    use HasFactory;

    public $translatable = ['name'];

    /**
     * fillable variable
     *
     * @var array
     */
    protected $fillable = ['user_id','class_id','level_id','school_id','role_id'];


    /**
     * User function
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * School function
     *
     * @return BelongsTo
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * LeveL function
     *
     * @return BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class)->withoutGlobalScopes();
    }
    /**
     * class function
     *
     * @return BelongsTo
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }
    /**
     * Role function
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
