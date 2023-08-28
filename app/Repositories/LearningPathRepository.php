<?php

namespace App\Repositories;
use App\Models\Country;
use App\Models\LearningPath;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class LearningPathRepository extends Repository
{
    /**
     * Model function
     *
     * @return string
     */
    public function model(): string
    {
        return LearningPath::class;
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
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $mission = $options['mission_id']?? null;
        $name = $options['name'] ?? null;
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if (isset($name)){
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale,'description->'.$dynamicLocale], $name);
        }

        if(isset($relation)){
            $query=$query->with($relation);
        }

        if (isset($order)) {
            $query = $query->orderBy('id',$order);
        }

        if($mission){
            $query=$query->whereHas('missions',function($q)use($mission){$q->where('mission_id', $mission);});
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
