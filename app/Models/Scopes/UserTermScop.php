<?php

namespace App\Models\Scopes;

use App\Models\Level;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserTermScop implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(auth()->user()->roles()->where('system_role',1)->exists()){
            $builder->whereNull('school_id');
        }
        elseif(auth()->user()->roles()->where('system_role',0)->where('code','schooladmin')->exists()
        && !auth()->user()->roles()->where('system_role',1)->exists()
        ){
            $builder->where('school_id', auth()->user()->school_id);

            }elseif(auth()->user()->enrollmentsRoles()->where('system_role',0)->exists()
            && !auth()->user()->roles()->where('system_role',1)->exists()
            ){

                $levelsIDs=Level::whereHas('enrollments', function($q){
                    $q->where('school_id',auth()->user()->school_id)->whereNotNull('school_id');
                })->pluck('id');

                $builder->whereHas('levels',function($q)use($levelsIDs){
                    $q->where('school_id', auth()->user()->school_id)->whereIn('level_id',$levelsIDs);
            });
        }
    }
}
