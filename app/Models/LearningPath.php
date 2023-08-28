<?php

namespace App\Models;

use App\Models\Scopes\UserLearningPathScop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LearningPath extends Model
{
    use HasTranslations,HasFactory;

    public $translatable = ['name','description'];

    protected $fillable = ['name','description'];


    //    /**
    //  * Globale Scope function
    //  *
    //  * @return void
    //  */
    // protected static function boot()
    // {
    //     parent::boot();
        // static::addGlobalScope(new UserLearningPathScop);
    // }

    public function missions() {
        return $this->belongsToMany(Mission::class,'mission_learningpaths')->withPivot('mission_id')->withoutGlobalScopes();
    }


    public function videos() {
        return $this->belongsToMany(VideoBank::class,'mission_videos')->withPivot('mission_id','is_selected','order');
    }

    public function papersWork() {
        return $this->belongsToMany(PeperWork::class,'mission_paper_works')->withPivot('mission_id','is_selected','order');
    }

    public function quizzes() {
        return $this->belongsToMany(Quiz::class,'mission_quizzes')->withPivot('mission_id','is_selected','order');
    }
}
