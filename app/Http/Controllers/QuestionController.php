<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\CreateQuestionRequest;
use App\Http\Requests\Question\UpdateQuestionRequest;
use App\Responses\ApiResponse;
use App\Services\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * _Construct function
     *
     * @param QuestionService $questionService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected QuestionService $questionService, protected ApiResponse $apiResponse)
    {
    }

    /**
     * Get All function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $question = $this->questionService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all',
            'level_id',
            'learning_path_id'
        ]));

        return $this->apiResponse
            ->setData($question['data'] ?? [])
            ->setMessages($question['messages'] ?? [])
            ->setErrors($question['errors'] ?? [])
            ->setCode($question['code'])
            ->setMeta($question['meta'])
            ->create();
    }

    /**
    * @param int $id
    * @return JsonResponse
    */
    public function show(int $id): JsonResponse
    {
        $question = $this->questionService->show($id);

        return $this->apiResponse
            ->setData($question['data'] ?? [])
            ->setMessages($question['messages'] ?? [])
            ->setErrors($question['errors'] ?? [])
            ->setCode($question['code'])
            ->create();
    }

    /**
     * @param int $id
     * @return JsonResponse
    */
    public function fullDetails(int $id): JsonResponse
    {
        $question = $this->questionService->fullDetails($id);

        return $this->apiResponse
            ->setData($question['data'] ?? [])
            ->setMessages($question['messages'] ?? [])
            ->setErrors($question['errors'] ?? [])
            ->setCode($question['code'])
            ->create();
    }


    /**
     * Create function
     *
     * @param CreateQuestionRequest $createQuestionRequest
     * @return JsonResponse
     */
    public function create(CreateQuestionRequest $createQuestionRequest): JsonResponse
    {
        $response = $this->questionService->create($createQuestionRequest->validated());
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
     * @param UpdateQuestionRequest $updateQuestionRequest
     * @return JsonResponse
     */
    public function update(int $id, UpdateQuestionRequest $updateQuestionRequest): JsonResponse
    {
        $response = $this->questionService->update($updateQuestionRequest->validated(), $id);
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
        $response = $this->questionService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
