<?php

namespace App\Repositories;

use App\Models\Term;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class TermRepository extends Repository
{
    public function model(): string
    {
        return Term::class;
    }


    public function getAll(array $options, string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $school = $options['school_id'] ?? null;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $name = $options['name'] ?? null;
        $listAll = $options['list_all'] ?? null;
        $level = $options['level_id'] ?? null;



        $query =  $this->model;

        if(isset($name)){
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale], $name);
        }

        if (isset($school)) {
            $query = $query->where('school_id',$school);
        }
        if (isset($school)) {
            $query = $query->whereHas('level_id',$school);
        }
        if (isset($level)) {
            $query = $query->whereHas('levels',function($q)use($level){
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
    public function show(int $id):object
    {
        $query =  $this->model;
        return $query->where('id',$id)->firstOrFail();
    }

}
