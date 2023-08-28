<?php

namespace App\Repositories;

use App\Models\LearningPath;
use App\Models\Mission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class MissionRepository extends Repository
{
    /**
     * Model function
     *
     * @return string
     */
    public function model(): string
    {
        return Mission::class;
    }

    /**
     * Get All function
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
        $level = isset($options['level_id']) ? $options['level_id'] :null;
        $listAll = $options['list_all'] ?? null;
        $name = $options['name'] ?? null;

        $query =  $this->model;

        if(isset($name)){
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale,'description->'.$dynamicLocale,
            'level.name->'.$dynamicLocale ,'learningPaths.name->'.$dynamicLocale], $name);
        }

        if(isset($relation)){
             $query=$query->with($relation);
        }

        if (isset($order)) {
            $query = $query->orderBy('id',$order);
        }

        if (isset($level)) {
            $query = $query->where('level_id',$level);
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
     *
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
     * Show function
     *
     * @param array $options
     * @param string|null $name
     * @return LengthAwarePaginator
     */
    public function schoolLevelDefaultMission(array $levelIds):object
    {
        $query =  $this->model;
        return $query=$query->whereIn('level_id',$levelIds)->whereNull('school_id')->get();
    }

     /**
     * Show function
     *
     * @param array $options
     * @param string|null $name
     *
     */
    public function schoolLevelDefaultMissions(int $levelId)
    {
        $query =  $this->model;
        return $query=$query->where('level_id',$levelId)->whereNull('school_id')->get();
    }

    /**
     * Class-Level-Default-Missions function
     *
     * @param array $options
     * @param string|null $name
     *
     */
    public function classLevelDefaultMissions(int $levelId,int $schoolId)
    {
        $query =  $this->model;
        return $query=$query->with('orginalMission')->where('level_id',$levelId)->where('school_id',$schoolId)->whereNull('class_id')->get();
    }


        /**
     * Class-Level-Default-Missions function
     *
     * @param array $options
     * @param string|null $name
     *
     */
    public function missionLearningPathContent(array $data)
    {
     return LearningPath::where('id',$data['learningpath_id'])
                            ->with(['videos' => function ($query)use($data){
                                $query->where('mission_id',$data['mission_id']);
                            }])
                             ->with(['quizzes' => function ($query)use($data){
                                $query->where('mission_id',$data['mission_id']);
                            }])
                            ->with(['papersWork'=> function ($query)use($data){
                                $query->where('mission_id',$data['mission_id']);
                            }])->firstOrFail();
    }








}
