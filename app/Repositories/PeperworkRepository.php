<?php
namespace App\Repositories;
use App\Models\PeperWork;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class PeperworkRepository extends Repository
{
    public function model(): string
    {
        return PeperWork::class;
    }

    public function getAll(array $options, array $relation = [],string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $name = $options['name'] ?? null;
        $level_id = $options['level_id'] ?? null;
        $term = $options['term_id'] ?? null;
        $learningpath = $options['learning_path_id'] ?? null;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $listAll = $options['list_all'] ?? null;


        $query =  $this->model;

        if (isset($name)) {
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale,'type','description->'.$dynamicLocale,
            'learningPath.name->'.$dynamicLocale,
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

        if(isset($listAll)){
            return $query->get();
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
