<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionProgressDetails extends Model
{
    use HasFactory;

    protected $fillable = ['mission_id','learning_path_id','total_path_jc','total_path_xp',
    'total_videos_xp','total_videos_jc','total_participatory_paper_works_jc','total_participatory_paper_works_xp',
    'total_single_paper_works_xp','total_single_paper_works_jc'
    ,'total_quizzes_jc','total_quizzes_xp'];



    /**
     * Belonsto function
     *
     * @return void
     */
    public function learningPath():BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }


    /**
     * Belonsto function
     *
     * @return void
     */
    public function mission():BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }
}
