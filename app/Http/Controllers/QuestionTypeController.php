<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionType\CreateQuestionTypeRequest;
use App\Http\Requests\QuestionType\UpdateQuestionTypeRequest;
use App\Responses\ApiResponse;
use App\Services\QuestionTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionTypeController extends Controller
{

    /**
     * _Construct function
     *
     * @param QuestionTypeService $qestionTypeService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected QuestionTypeService $qestionTypeService,protected ApiResponse $apiResponse){}


    /**
     * Get All function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $schoolGroups = $this->qestionTypeService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all',
            'parent_id',
            'main_questions'

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
        $schoolGroups = $this->qestionTypeService->show($id);

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
     * @param CreateQuestionTypeRequest $createQuestionTypeRequest
     * @return JsonResponse
     */
    public function create(CreateQuestionTypeRequest $createQuestionTypeRequest): JsonResponse
    {
        $response = $this->qestionTypeService->create($createQuestionTypeRequest->validated());
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
     * @param UpdateQuestionTypeRequest $updateQuestionTypeRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateQuestionTypeRequest $updateQuestionTypeRequest): JsonResponse
    {
        $response = $this->qestionTypeService->update($updateQuestionTypeRequest->validated(), $id);
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
        $response = $this->qestionTypeService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
