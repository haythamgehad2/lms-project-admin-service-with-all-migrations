<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolGroup\CreateSchoolGroupRequest;
use App\Http\Requests\SchoolGroup\UpdateSchoolGroupRequest;
use App\Models\SchoolGroup;
use App\Responses\ApiResponse;
use App\Services\SchoolGroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolGroupController extends Controller
{
    public function __construct(protected SchoolGroupService $schoolGroupService,protected ApiResponse $apiResponse){}


    public function index(Request $request): JsonResponse
    {
        $schoolGroups = $this->schoolGroupService->getAll($request->only([
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
        $schoolGroups = $this->schoolGroupService->show($id);

        return $this->apiResponse
            ->setData($schoolGroups['data'] ?? [])
            ->setMessages($schoolGroups['messages'] ?? [])
            ->setErrors($schoolGroups['errors'] ?? [])
            ->setCode($schoolGroups['code'])
            ->create();
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function fullDetails(int $id): JsonResponse
    {
        $schoolGroups = $this->schoolGroupService->fullDetails($id);

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
     * @param CreateSchoolGroupRequest $createSchoolGroupRequest
     * @return JsonResponse
     */
    public function create(CreateSchoolGroupRequest $createSchoolGroupRequest): JsonResponse
    {
        $response = $this->schoolGroupService->create($createSchoolGroupRequest->validated());
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
     * @param UpdateSchoolGroupRequest $updateSchoolGroupRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateSchoolGroupRequest $updateSchoolGroupRequest): JsonResponse
    {
        $response = $this->schoolGroupService->update($updateSchoolGroupRequest->validated(), $id);
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
        $response = $this->schoolGroupService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
