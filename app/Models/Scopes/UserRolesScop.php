<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserRolesScop implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(auth()->user()->roles()->where('system_role',0)->where('code','schooladmin')->exists()
        && !auth()->user()->roles()->where('system_role',1)->exists() && auth()->user()->is_school_admin == 1 && isset(auth()->user()->school_id)
        ){
            $builder->where('code', 'teacher')->orWhere(function ($query) {
                $query->where('code', 'supervisor');
            });

        }
    }
}
