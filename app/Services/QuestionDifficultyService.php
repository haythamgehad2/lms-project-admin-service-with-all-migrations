<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Requests\QuestionDifficulty\UpdateQuestionDifficultyPoints;
use App\Http\Resources\QuestionDifficulty\QuestionDifficultiesResource;
use App\Http\Resources\QuestionDifficulty\QuestionDifficulyResource;
use App\Http\Resources\SchoolGroup\SchoolGroupResource;
use App\Http\Resources\SchoolGroup\SchoolGroupsResource;
use App\Mapper\PaginationMapper;
use App\Repositories\QuestionDifficultyRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QuestionDifficultyService
{
    public function __construct(protected QuestionDifficultyRepository $questionDifficultyRepository, protected PaginationMapper $paginationMapper, protected ReturnData $returnData)
    {
    }


    public function getAll(array $options = [])
    {
        $questionDifficulties = $this->questionDifficultyRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            QuestionDifficultiesResource::collection($questionDifficulties),
            __('admin.questions_difficulties.list'),
            $questionDifficulties instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options, $questionDifficulties) : []
        );

    }


    /**
    * Show function
    *
    * @param array $options
    * @return void
    */
    public function show(int $id)
    {
        $questionDifficulty = $this->questionDifficultyRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new QuestionDifficulyResource($questionDifficulty),
            [__('admin.questions_difficulties.show')],
        );
    }
    /**
     * Create function
     *
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $questionDifficulty = $this->questionDifficultyRepository->create($data);

            DB::commit();
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                new QuestionDifficulyResource($questionDifficulty),
                [__('admin.questions_difficulties.create')]
            );

        } catch (Exception $excption) {
            logger(
                [
                    'error' =>$excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.questions_difficulties.not_create')],
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
            $questionDifficulty=$this->questionDifficultyRepository->update($data, $id);

            DB::commit();
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                new QuestionDifficulyResource($questionDifficulty),
                [__('admin.questions_difficulties.update')]
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
                [__('admin.questions_difficulties.not_update')],
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
            $this->questionDifficultyRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.questions_difficulties.delete')]
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
                [__('admin.questions_difficulties.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
     * @param integer $id
     * @param UpdateQuestionDifficultyPoints $request
     * @return array
     */
    public function updatePoints(int $id, UpdateQuestionDifficultyPoints $request): array
    {
        $questionDifficulty = $this->questionDifficultyRepository->update(
            ["grade_points" => $request->get("grade_points")],
            $id
        );
        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new QuestionDifficulyResource($questionDifficulty),
            [__('admin.questions_difficulties.update')]
        );
    }
}
