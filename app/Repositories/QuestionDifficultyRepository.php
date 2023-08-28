<?php
namespace App\Repositories;

use App\Models\QuestionDifficulty;
use App\Models\SchoolGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class QuestionDifficultyRepository extends Repository
{
    public function model(): string
    {
        return QuestionDifficulty::class;
    }


    public function getAll(array $options, array $relation = []): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $name = $options['name'] ?? null;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if(isset($name)) {
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale], $name);
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
    public function show(int $id, array $relation=[]):object
    {
        $query =  $this->model;

        if(isset($relation)){
                $query=$query->with($relation);
        }

        return $query->where('id',$id)->firstOrFail();
    }


    /**
     * getAllWithoutPaginate function
     *
     * @return array
     */
    public function getAllWithoutPaginate(array $options): Collection
    {
        $query =  $this->model;
        $level = $options['level_id'] ?? null;
        $learning_path_id = $options['learning_path_id'] ?? null;



        if (isset($level)) {
            $query = $query->withCount([
                'questions as questions_count' => function ($query) use($level,$learning_path_id) {
                    $query->where('level_id',$level)->where('learning_path_id',$learning_path_id);
                },
            ])->whereHas('questions',function($q)use($level,$learning_path_id){
                $q->where('level_id',$level)->where('learning_path_id',$learning_path_id);
            });
        }

        return $query->get();
    }




}
