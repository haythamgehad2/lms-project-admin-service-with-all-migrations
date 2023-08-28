<?php
namespace App\Repositories;

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\SchoolGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class QuestionAnswerRepository extends Repository
{
    public function model(): string
    {
        return QuestionAnswer::class;
    }


    public function getAll(array $options, array $relation = [],string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if (isset($name)) {
            $query = $query->where('name','like',"%$name%");
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
     /**
     * Get All function
     *
     * @param array $options
     * @param string|null $name
     * @return LengthAwarePaginator
     */
    public function deleteAnswers(int $questionId)
    {
        $query =  $this->model;
       return $query->where('question_id',$questionId)->delete();

    }

    //  /**
    //  * {@inheritDoc}
    //  *
    //  * @param  string column
    //  * @param  array         $array
    //  * @return Collection|Model[]|AppModel[]
    //  */
    // public function deleteAnswer(string $column, array $values,string $value)
    // {
    //     return $this->model->whereNotIn($column, $values)->where('question_id',$value)->delete();
    // }

}
