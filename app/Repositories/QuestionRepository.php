<?php
namespace App\Repositories;

use App\Models\Question;
use App\Models\SchoolGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class QuestionRepository extends Repository
{
    public function model(): string
    {
        return Question::class;
    }


    public function getAll(array $options, array $relation = [],string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $learningPathId = $options['learning_path_id'] ?? null;
        $levelId = $options['level_id'] ?? null;
        $listAll = $options['list_all'] ?? null;
        $name = $options['name'] ?? null;




        $query =  $this->model;

        if(isset($name)) {
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['question->'.$dynamicLocale,'questionType.name->'.$dynamicLocale,
            'subQuestionType.name->'.$dynamicLocale,'questionDifficulty.name->'.$dynamicLocale,
            'learningPath.name->'.$dynamicLocale,'level.name->'.$dynamicLocale
        ], $name);
        }


        if (isset($levelId)) {
            $query = $query->where('level_id',$levelId);
        }

        if (isset($learningPathId)) {
            $query = $query->where('learning_path_id',$learningPathId);
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
     * Get All function
     *
     * @param array $options
     * @param string|null $name
     * @return object
     */
    public function deleteAnswers(int $questionId)
    {
        $query =  $this->model;
       return $query->where('question_id',$questionId)->delete();

    }

      /**
     * Get All function
     *
     * @param array $options
     * @param string|null $name
     * @return array
     */
    public function quizDefultQeustions(int $question_difficulty_id,int $level_id)
    {
        $query=$this->model;
        return $query->where('question_difficulty_id',$question_difficulty_id)->where('level_id',$level_id)->pluck('id');

    }

      /**
     * Get All function
     *
     * @param array $options
     * @param string|null $name
     * @return object
     */
    public function quizQuestionDifficulty(array $questionIds,int $level_id)
    {
        $query=$this->model;
        return  $query->whereIn('id',$questionIds)->where('level_id',$level_id)->
        groupBy('question_difficulty_id')->select('question_difficulty_id', DB::raw('count(*) as total_question'))->get();


    }

     /**
     * getAllWithoutPaginate function
     *
     * @return array
     */
    public function getAllWithoutPaginate(array $options)
    {
        $query =  $this->model;
        $level = $options['level_id'] ?? null;

        if (isset($level)) {
            $query = $query->select('question_difficulty_id')->with('questionDifficulty')->where('level_id',$level)->groupBy('question_difficulty_id')->select('question_difficulty_id', DB::raw('count(*) as total_question'));
        }

        return $query->get();
    }

     /**
     * Get All function
     *
     * @param array $options
     * @param string|null $name
     * @return object
     */
    public function getRandomQuestion(array $data)
    {
        $query=$this->model;

        $questions = collect();

        foreach($data['question_difficuly'] as $questionDifficulty){

            $questionsDifficulty= $query->select('question','id')->
                 where('question_difficulty_id',$questionDifficulty['question_difficulty_id'])->
                 where('level_id',$data['level_id'])->
                 where('learning_path_id',$data['learning_path_id'])->
                 limit($questionDifficulty['questions_count'])->orderBy('id','DESC')->get();
               $questions->push($questionsDifficulty);
        }

        return $questions->flatten();

    }







}
