<?php

namespace App\Repositories;

use App\Models\SchoolType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolTypeRepository extends Repository
{
    public function model(): string
    {
        return SchoolType::class;
    }


    public function getAll(array $options, array $relation=[],string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $name = $options['name'] ?? null;
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if(isset($name)){
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale], $name);
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
    public function show(int $id, array $relation=[]):object
    {
        $query =  $this->model;

        if(isset($relation)){
                $query=$query->with($relation);
        }

        return $query->where('id',$id)->firstOrFail();
    }

}
