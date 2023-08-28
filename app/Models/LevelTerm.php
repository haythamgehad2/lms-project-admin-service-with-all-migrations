<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LevelTerm extends Model
{
    use HasFactory;
    protected $fillable = ['term_id','level_id','school_id'];
    /**
     * term function
     *
     * @return BelongsTo
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class)->withoutGlobalScopes();
    }


     /**
     * level function
     *
     * @return BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class)->withoutGlobalScopes();
    }
}
