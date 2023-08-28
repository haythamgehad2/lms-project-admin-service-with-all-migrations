<?php

namespace App\Repositories;

use App\Models\Level;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ThemeRepository extends Repository
{
    /**
     * Model Return function
     *
     * @return string
     */
    public function model(): string
    {
        return Theme::class;
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
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if (isset($name)) {
            $query = $query->where('name','like',"%$name%");
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
