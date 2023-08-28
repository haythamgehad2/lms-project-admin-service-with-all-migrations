<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class PackageRepository extends Repository
{
    public function model(): string
    {
        return Package::class;
    }


    /**
     * Get All function
     *
     * @param array $options
     * @param array $relation
     * @param string|null $name
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $options, array $relation = [],string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $name = isset($options['name']) ? $options['name']: null;
        $listAll = $options['list_all'] ?? null;
        $query =  $this->model;

        if (isset($name)) {
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale,'description->'.$dynamicLocale,'price','classes_count'], $name);
        }

        if(isset($relation)){
             $query=$query->with($relation);
        }

        if (isset($order)) {
            $query = $query->orderBy('id',$order);
        }

        if(isset($listAll)){
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
