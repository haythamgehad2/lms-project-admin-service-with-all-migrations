<?php

namespace App\Repositories;

use App\Models\Class;
use App\Models\Classes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class ClassRepository extends Repository
{

    public function model(): string
    {
        return Classes::class;
    }


    public function getAll(array $options, string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $school = $options['school_id'] ?? null;
        $order = isset($options['order']) ? $options['order'] :'asc';
        $level = $options['level_id'] ?? null;
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if (isset($name)) {
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale], $name);
        }

        if (isset($school)) {
            $query = $query->where('school_id',$school);
        }
        if (isset($level)) {

            $query = $query->whereHas('levelTerm',function($q)use($level){
                $q->where('level_id',$level);
            });
        }

        if (isset($order)) {
            $query = $query->orderBy('id',$order);
        }

        if(isset($listAll) && $listAll == true){
            return $query->get();
         }


        return $query->paginate($length, ['*'], 'page', $page);
    }

    /**
     * Get All function
     *
     * @param array $options
     * @param string|null $name
     * @return LengthAwarePaginator
     */
    public function show(int $id, array $relation = []):object
    {
        $query =  $this->model;

        if(isset($relation)){
                $query=$query->with($relation);
        }

        return $query->where('id',$id)->firstOrFail();
    }

}
