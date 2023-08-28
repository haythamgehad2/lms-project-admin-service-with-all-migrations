<?php

namespace App\Repositories;
use App\Models\VideoBank;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class VideoBankRepository extends Repository
{
    /**
     * Model function
     *
     * @return string
     */
    public function model(): string
    {
        return VideoBank::class;
    }
    /**
     * Get List function
     *
     * @param array $options
     * @param array $relation
     * @param string|null $name
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $options, array $relation=[],string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $level_id = $options['level_id'] ?? null;
        $learningpath = $options['learning_path_id'] ?? null;
        $term = $options['term_id'] ?? null;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $name = $options['name'] ?? null;
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if(isset($name)) {
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['title->'.$dynamicLocale,'description->'.$dynamicLocale,'learningPath.name->'.$dynamicLocale,
            'level.name->'.$dynamicLocale], $name);
        }

        if (isset($level_id)) {
            $query = $query->where('level_id',$level_id);
        }

        if (isset($term)) {
            $query = $query->where('term_id',$term);
        }

        if (isset($learningpath)) {
            $query = $query->where('learning_path_id',$learningpath);
        }

        if(isset($relation)){
            $query=$query->with($relation);
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
