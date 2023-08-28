<?php

namespace App\Repositories;

use App\Models\Level;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class LevelRepository extends Repository
{
    public function model(): string
    {
        return Level::class;
    }


    /**
     * Get All function
     *
     * @param array $options
     * @param string|null $name
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $options, string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 1000;
        $school = $options['school_id'] ?? null;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $name = $options['name'] ?? null;
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if (isset($order)) {
            $query = $query->orderBy('id',$order);
        }

        if (isset($name)) {
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale], $name);
        }
        if (isset($school)){
            $query = $query->where('school_id',$school);
        }

        if(isset($listAll) && $listAll == true){
            return $query->get();
         }

        return $query->paginate($length, ['*'], 'page', $page);
    }

    /**
     * Show function
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


    /**
     * School Level function
     *
     * @param integer $schoolId
     * @return array
     */
    public function schoolLevel(int $schoolId):Collection
    {
        $query =  $this->model;
        return $query->where('school_id',$schoolId)->get();
    }



}
