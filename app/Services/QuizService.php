<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\Quiz\QuizRandomQuestionsResource;
use App\Http\Resources\Quiz\QuizResource;
use App\Http\Resources\Quiz\QuizzesResource;
use App\Http\Resources\QuizQuestionDiffuclty\QuestionDifficultyQuizResoruce;
use App\Mapper\PaginationMapper;
use App\Repositories\QuestionDifficultyRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\QuizRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QuizService
{
    /**
     * __Construct function
     *
     * @param QuizRepository $quizRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(
        protected QuizRepository $quizRepository,
        protected QuestionRepository $questionRepository,
        protected QuestionDifficultyRepository $questionDifficultyRepository,
        protected PaginationMapper $paginationMapper,
        protected ReturnData $returnData
    ) {
    }

    /**
     * GetAll function
     * @param array $options
     * @return void
     */
    public function getAll(array $options = [])
    {
        $quizzes = $this->quizRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            QuizzesResource::collection($quizzes),
            [__('admin.quizzes.list')],
            $quizzes instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options, $quizzes) : []
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
        $quiz = $this->quizRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new QuizResource($quiz),
            [__('admin.quizzes.show')],
        );
    }

    /**
    * Show function
    *
    * @param array $options
    * @return array
    */
    public function getRandomQuestion(array $data)
    {
        $questions = $this->questionRepository->getRandomQuestion($data);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            QuizRandomQuestionsResource::collection($questions),
            [__('Question item returned successfully')],
        );
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

            $quiz = $this->quizRepository->create($data);

            // if($data['type']== 'default'){

            //     foreach($data['question_defficulties'] as $question){

            //     $questionIds=$this->questionRepository->quizDefultQeustions($question['id'],$data['level_id']);
            //         if($questionIds){
            //              $quiz->quizQuestions()->attach($questionIds);
            //          }

            //     }

            // }elseif($data['type']== 'manual'){
            $questionDifficulties=$this->questionRepository->quizQuestionDifficulty($data['questions'], $data['level_id']);

            foreach($questionDifficulties as $diffuclty) {
                $quiz->questionsDifficulties()->attach($diffuclty->question_difficulty_id, ['total_question'=>$diffuclty->total_question]);
            }

            $quiz->quizQuestions()->attach($data['questions']);
            // }

            $quiz->updateGradPoints();
            DB::commit();

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                new QuizResource($quiz),
                [__('admin.quizzes.create')]
            );
        } catch(Exception $excption) {
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
                [__('admin.quizzes.not_create')],
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
    public function questionDifficultyList(array $options)
    {
        $questionDifficulty = $this->questionDifficultyRepository->getAllWithoutPaginate($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            QuestionDifficultyQuizResoruce::collection($questionDifficulty),
            [__('admin.questions_difficulties.list')],
        );
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

            $quiz =$this->quizRepository->update($data, $id);

            $questionDifficulties=$this->questionRepository->quizQuestionDifficulty($data['questions'], $data['level_id']);

            $quiz->questionsDifficulties()->detach();

            foreach($questionDifficulties as $diffuclty) {
                $quiz->questionsDifficulties()->sync([$diffuclty->question_difficulty_id=>['total_question'=>$diffuclty->total_question]], false);
            }

            $quiz->quizQuestions()->sync($data['questions']);

            $quiz->updateGradPoints();
            DB::commit();

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                new QuizResource($quiz),
                [__('admin.quizzes.update')]
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
                [__('admin.quizzes.not_update')],
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
            $this->quizRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.quizzes.delete')]
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
                [__('admin.quizzes.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
