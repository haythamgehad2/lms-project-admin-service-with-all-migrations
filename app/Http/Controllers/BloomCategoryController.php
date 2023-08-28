<?php

namespace App\Http\Controllers;

use App\Http\Requests\BloomCategory\CreateBloomCategoryRequest;
use App\Http\Requests\BloomCategory\UpdateBloomCategoryRequest;
use App\Responses\ApiResponse;
use App\Services\BloomCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BloomCategoryController extends Controller
{

    /**
     * _Construct function
     *
     * @param QuestionTypeService $bloomCategoryService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected BloomCategoryService $bloomCategoryService,protected ApiResponse $apiResponse){}


    /**
     * Get All function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $schoolGroups = $this->bloomCategoryService->getAll($request->only([
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
        $schoolGroups = $this->bloomCategoryService->show($id);

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
     * @param CreateBloomCategoryRequest $createBloomCategoryRequest
     * @return JsonResponse
     */
    public function create(CreateBloomCategoryRequest $createBloomCategoryRequest): JsonResponse
    {
        $response = $this->bloomCategoryService->create($createBloomCategoryRequest->validated());
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
     * @param UpdateBloomCategoryRequest $updateBloomCategoryRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateBloomCategoryRequest $updateBloomCategoryRequest): JsonResponse
    {
        $response = $this->bloomCategoryService->update($updateBloomCategoryRequest->validated(), $id);
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
        $response = $this->bloomCategoryService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
