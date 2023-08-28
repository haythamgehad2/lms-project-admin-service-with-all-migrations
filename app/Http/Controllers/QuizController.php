<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\CreateQuizRequest;
use App\Http\Requests\Quiz\QuestionDifficultyInfoRequest;
use App\Http\Requests\Quiz\QuizRandomQuestion;
use App\Http\Requests\Quiz\QuizRandomQuestionRequest;
use App\Http\Requests\Quiz\UpdateQuizRequest;
use App\Responses\ApiResponse;
use App\Services\QuizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    /**
    * __construct function
    *
    * @param QuizService $quizService
    * @param ApiResponse $apiResponse
    */
   public function __construct(protected QuizService $quizService,protected ApiResponse $apiResponse){}

       /**
        * index function
        *
        * @param Request $request
        * @return JsonResponse
        */
       public function index(Request $request): JsonResponse
       {
           $quizzies = $this->quizService->getAll($request->only([
               'per_page',
               'page',
               'name',
               'order',
               'list_all',
               'level_id',
               'term_id',
               'learning_path_id'
           ]));
           return $this->apiResponse
               ->setData($quizzies['data'] ?? [])
               ->setMessages($quizzies['messages'] ?? [])
               ->setErrors($quizzies['errors'] ?? [])
               ->setCode($quizzies['code'])
               ->setMeta($quizzies['meta'])
               ->create();
       }
       /**
        * Show function
        *
        * @param int $id
        * @return JsonResponse
        */
       public function show(int $id): JsonResponse
       {
           $quiz = $this->quizService->show($id);

           return $this->apiResponse
               ->setData($quiz['data'] ?? [])
               ->setMessages($quiz['messages'] ?? [])
               ->setErrors($quiz['errors'] ?? [])
               ->setCode($quiz['code'])
               ->create();
       }

        /**
         * Show function
         *
         * @param CreateSchoolGroupRequest $createSchoolGroupRequest
         * @return JsonResponse
         */
        public function getRandomQuestion(QuizRandomQuestionRequest $request): JsonResponse
        {
            $question = $this->quizService->getRandomQuestion($request->validated());

            return $this->apiResponse
                ->setData($question['data'] ?? [])
                ->setMessages($question['messages'] ?? [])
                ->setErrors($question['errors'] ?? [])
                ->setCode($question['code'])
                ->create();
        }

        /**
        * Show function
        *
        * @param int $id
        * @return JsonResponse
        */
       public function questionDifficultyList(QuestionDifficultyInfoRequest $request): JsonResponse
       {
        $questionDifficulties = $this->quizService->questionDifficultyList($request->validated());

        return $this->apiResponse
            ->setData($questionDifficulties['data'] ?? [])
            ->setMessages($questionDifficulties['messages'] ?? [])
            ->setErrors($questionDifficulties['errors'] ?? [])
            ->setCode($questionDifficulties['code'])
            ->create();
       }
       /**
        * Create function
        *
        * @param CreatePeperworkRequest $preatePeperworkRequest
        * @return JsonResponse
        */
       public function create(CreateQuizRequest $createQuizRequest): JsonResponse
       {
           $response = $this->quizService->create($createQuizRequest->validated());
           return $this->apiResponse
               ->setData($response['data'] ?? [])
               ->setMessages($response['messages'] ?? [])
               ->setErrors($response['errors'] ?? [])
               ->setCode($response['code'])
               ->create();
       }
       /**
        * Update function
        *
        * @param integer $id
        * @param UpdatePeperworkRequest $updatePeperworkRequest
        * @return JsonResponse
        */
       public function update(int $id,UpdateQuizRequest $updatePeperworkRequest): JsonResponse
       {
           $response = $this->quizService->update($updatePeperworkRequest->validated(), $id);
           return $this->apiResponse
               ->setData($response['data'] ?? [])
               ->setMessages($response['messages'] ?? [])
               ->setErrors($response['errors'] ?? [])
               ->setCode($response['code'])
               ->create();
       }
       /**
        * Delete function
        *
        * @param integer $id
        * @return JsonResponse
        */
       public function delete(int $id): JsonResponse
       {
           $response = $this->quizService->delete($id);
           return $this->apiResponse
               ->setData($response['data'] ?? [])
               ->setMessages($response['messages'] ?? [])
               ->setErrors($response['errors'] ?? [])
               ->setCode($response['code'])
               ->create();
       }
   }
