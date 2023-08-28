<?php

namespace App\Services;

use App\Events\MissionProgressEvent;
use App\Helpers\ReturnData;
use App\Http\Resources\Mission\MissionFullDetailsResource;
use App\Http\Resources\Mission\MissionLearningPathResource;
use App\Http\Resources\Mission\MissionLearningPathsResource;
use App\Http\Resources\Mission\MissionPathContentResource;
use App\Http\Resources\Mission\MissionPathContentsResource;
use App\Http\Resources\Mission\MissionResource;
use App\Http\Resources\Mission\MissionsResource;
use App\Mapper\PaginationMapper;
use App\Models\Level;
use App\Models\Mission;
use App\Models\Quiz;
use App\Repositories\MissionRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MissionService
{
    /**
     * __construct function
     *
     * @param MissionRepository $missionRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected MissionRepository $missionRepository, protected PaginationMapper $paginationMapper, protected ReturnData $returnData)
    {
    }


    /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = [])
    {
        $missions = $this->missionRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            MissionsResource::collection($missions),
            __('admin.missions.list'),
            $missions instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options, $missions) : []
        );

    }

    /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function missionLearningPath(int $id)
    {

        $mission = $this->missionRepository->show($id);
        $learningPaths = $mission->learningPaths;

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            MissionLearningPathsResource::collection($learningPaths),
            [__('admin.learningpaths.show')],
        );

    }

    /**
    * Show function
    *
    * @param array $options
    * @return array
    */
    public function show(int $id)
    {
        $term = $this->missionRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new MissionResource($term),
            [__('admin.missions.show')],
        );
    }

    /**
     * @param int $id
     * @return array
    */
    public function fullDetails(int $id): array
    {
        $mission = $this->missionRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new MissionFullDetailsResource(
                $mission->load([
                    "level",
                    "term",
                    "country",
                    "learningPaths" => fn($learningQuery) => $learningQuery->with([
                        "videos" => fn($q) => $q->where("mission_id", $id),
                        "quizzes" => fn($q) => $q->where("mission_id", $id),
                        "papersWork" => fn($q) => $q->where("mission_id", $id),
                    ])
                ])
            ),
            [__('admin.missions.show')],
        );
    }


    /**
    * Show function
    *
    * @param array $options
    * @return array
    */
    public function missionLearningPathContent(array $data)
    {
        $term = $this->missionRepository->missionLearningPathContent($data);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new MissionPathContentsResource($term),
            [__('admin.missions.list_contents')],
        );
    }

    /**
    * Show function
    *
    * @param array $options
    * @return array
    */
    public function handelLearningPathContent(array $data)
    {

        DB::beginTransaction();

        try {
            $mission = Mission::where('id', $data['mission_id'])->firstOrfail();
            $mission->learningPathVideos()->updateExistingPivot($data['learningpath_id'], ['is_selected' => 0]);
            $mission->learningPathQuizzes()->updateExistingPivot($data['learningpath_id'], ['is_selected' => 0]);
            $mission->learningPathPapersWorks()->updateExistingPivot($data['learningpath_id'], ['is_selected' => 0]);

            if($data['videos']) {
                $mission->learningPathVideos()->wherePivotIn('video_bank_id', $data['videos'])->updateExistingPivot($data['learningpath_id'], ['is_selected' => 1]);

            }
            if($data['quizzes']) {
                foreach($data['quizzes'] as $quiz) {
                    $quizData = Quiz::findOrFail($quiz['id']);
                    $mission->learningPathQuizzes()->wherePivot('quiz_id', $quiz['id'])->updateExistingPivot($data['learningpath_id'], ['is_selected' => 1]);
                    $quizData->questions()->update(array('is_selected' => 0));
                    $quizData->questions()->wherePivotIn('question_id', $quiz['questions'])->update(array('is_selected' => 1));

                }
            }

            if($data['papersworks']) {
                $mission->learningPathPapersWorks()->wherePivotIn('peper_work_id', $data['papersworks'])->updateExistingPivot($data['learningpath_id'], ['is_selected' => 1]);
            }

            event(new MissionProgressEvent($mission));


            DB::commit();
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.mission.selected_learningpath_content_success')]
            );

        } catch (Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.mission.selected_learningpath_content_error')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );

        }

    }




    /**
     * Create function
     *
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $mission = $this->missionRepository->create($data);

            foreach ($data['learningpaths'] as $learningPathIndex => $learningPathData) {

                $mission->learningPaths()->attach([$learningPathData['id']]);

                foreach ($learningPathData['videos'] as $videoIndex => $videoData) {

                    $mission->videosBanks()->attach($videoData['id'], ['is_selected' => 1,'order' => $videoData['order'],'learning_path_id' => $learningPathData['id']]);

                }

                foreach ($learningPathData['papersworks'] as $papersworkIndex => $papersworkData) {

                    $mission->papersWork()->attach($papersworkData['id'], ['is_selected' => 1,'order' => $papersworkData['order'],'learning_path_id' => $learningPathData['id']]);

                }

                foreach ($learningPathData['quizzes'] as $quizIndex => $quizData) {
                    $mission->quizzes()->attach($quizData['id'], ['is_selected' => 1,'order' => $quizData['order'],'learning_path_id' => $learningPathData['id']]);

                }

            }


            if(isset($data['mission_image'])) {
                $mission->saveFiles($data['mission_image']);
            }

            DB::commit();
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.missions.create')]
            );

        } catch (Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.missions.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }

    }

    /**
     * Update function
     *
     * @param array $data
     * @param integer $id
     * @return array
     */
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $mission = $this->missionRepository->update($data, $id);

            if(isset($data['mission_image'])) {
                $mission->updateFile($data['mission_image']);
            }

            $mission->learningPaths()->detach();
            $mission->videosBanks()->detach();
            $mission->papersWork()->detach();
            $mission->quizzes()->detach();

            foreach ($data['learningpaths'] as $learningPathIndex => $learningPathData) {

                $mission->learningPaths()->attach([$learningPathData['id']]);

                foreach ($learningPathData['videos'] as $videoIndex => $videoData) {
                    $mission->videosBanks()->attach($videoData['id'], ['is_selected' => 1,'order' => $videoData['order'],'learning_path_id' => $learningPathData['id']]);
                }

                foreach ($learningPathData['papersworks'] as $papersworkIndex => $papersworkData) {

                    $mission->papersWork()->attach($papersworkData['id'], ['is_selected' => 1,'order' => $papersworkData['order'],'learning_path_id' => $learningPathData['id']]);

                }

                foreach ($learningPathData['quizzes'] as $quizIndex => $quizData) {
                    $mission->quizzes()->attach($quizData['id'], ['is_selected' => 1,'order' => $quizData['order'],'learning_path_id' => $learningPathData['id']]);

                }
            }
            DB::commit();
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                new MissionResource($mission),
                [__('admin.missions.update')]
            );

        } catch (Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );
            DB::rollback();

            return $this->returnData->create(
                [__('admin.missions.not_update')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }

    }

    /**
     * Delete function
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id)
    {
        try {
            $this->missionRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.missions.delete')]
            );
        } catch (Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('admin.missions.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
     * Dublicate Mission function
     *
     * @param integer $id
     * @return void
     */
    public function duplicateMission(int $id)
    {
        try {
            $mission = $this->missionRepository->find($id);
            $newMission = $mission->replicate();
            $newMission->name = [app()->getLocale() => $newMission->name."_copy"];
            $newMission->save();

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('Duplicate mission has been successfully')]
            );
        } catch (Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('Mission has not been duplicate')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
    * Dublicate Mission function
    *
    * @param integer $id
    * @return void
    */
    public function rearrangeMissions(array $data)
    {
        DB::beginTransaction();

        try {

            $level = Level::findOrfail($data['level_id']);

            if($level->min_levels > count($data['missions'])) {
                return $this->returnData->create(
                    [],
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    [],
                    [__('sorry you missions not reach the minimum number')]
                );
            }

            Mission::where('level_id', $data['level_id'])->whereNotNull('school_id')->update(['order' => null,'is_selected' => 0,'start_date' => null,'end_date' => null]);

            foreach($data['missions'] as $mission) {
                $missionData = $this->missionRepository->find($mission['id']);
                $missionData->order = $mission['order'];
                $missionData->is_selected = $mission['is_selected'];
                $missionData->start_date = $mission['start_date'];
                $missionData->end_date = $mission['end_date'];
                $missionData->save();

                Mission::where('original_id', $mission['id'])->whereNotNull('class_id')->whereNotNull('school_id')
                ->update(['is_selected' => $mission['is_selected'],'start_date' => $mission['start_date'],'end_date' => $mission['end_date'],
                'order' => $mission['order']
                ]);
            }

            DB::commit();

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.missions.rearrange_success')]
            );
        } catch (Exception $excption) {
            dd($excption->getMessage());
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollBack();

            return $this->returnData->create(
                [__('admin.missions.rearrange_error')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
