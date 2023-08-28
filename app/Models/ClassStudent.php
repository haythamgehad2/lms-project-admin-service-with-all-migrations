<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassStudent extends Model
{
    use HasFactory;

    /**
     * fillable variable
     *
     * @var array
     */
    protected $fillable = ['user_id','class_id','school_id','is_current'];

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
     * class function
     *
     * @return BelongsTo
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }
}
