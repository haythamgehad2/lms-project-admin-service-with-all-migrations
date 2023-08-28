<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionDifficulty\CreateQuestionDifficultyRequest;
use App\Http\Requests\QuestionDifficulty\UpdateQuestionDifficultyPoints;
use App\Http\Requests\QuestionDifficulty\UpdateQuestionDifficultyRequest;
use App\Responses\ApiResponse;
use App\Services\QuestionDifficultyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionDifficultyController extends Controller
{
    /**
     * _Construct function
     *
     * @param QuestionDifficultyService $questionDifficultyService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected QuestionDifficultyService $questionDifficultyService, protected ApiResponse $apiResponse)
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
        $schoolGroups = $this->questionDifficultyService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all'
        ]));

        return $this->apiResponse
            ->setData($schoolGroups['data'] ?? [])
            ->setMessages($schoolGroups['messages'] ?? [])
            ->setErrors($schoolGroups['errors'] ?? [])
            ->setCode($schoolGroups['code'])
            ->setMeta($schoolGroups['meta'])
            ->create();
    }


    /**
    * Show function
    *
    * @param CreateSchoolGroupRequest $createSchoolGroupRequest
    * @return JsonResponse
    */
    public function show(int $id): JsonResponse
    {
        $schoolGroups = $this->questionDifficultyService->show($id);

        return $this->apiResponse
            ->setData($schoolGroups['data'] ?? [])
            ->setMessages($schoolGroups['messages'] ?? [])
            ->setErrors($schoolGroups['errors'] ?? [])
            ->setCode($schoolGroups['code'])
            ->create();
    }
    /**
     * Create function
     *
     * @param CreateQuestionDifficultyRequest $createQuestionDifficultyRequest
     * @return JsonResponse
     */
    public function create(CreateQuestionDifficultyRequest $createQuestionDifficultyRequest): JsonResponse
    {
        $response = $this->questionDifficultyService->create($createQuestionDifficultyRequest->validated());
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
     * @param UpdateQuestionDifficultyRequest $updateQuestionDifficultyRequest
     * @return JsonResponse
     */
    public function update(int $id, UpdateQuestionDifficultyRequest $updateQuestionDifficultyRequest): JsonResponse
    {
        $response = $this->questionDifficultyService->update($updateQuestionDifficultyRequest->validated(), $id);
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
        $response = $this->questionDifficultyService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * @param UpdateQuestionDifficultyPoints $request
     * @param integer $id
     * @return JsonResponse
     */
    public function updatePoints(UpdateQuestionDifficultyPoints $request, int $id): JsonResponse
    {
        $response = $this->questionDifficultyService->updatePoints($id, $request);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
