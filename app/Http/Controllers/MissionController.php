<?php

namespace App\Http\Controllers;
use App\Http\Requests\Mission\CreateMissionRequest;
use App\Http\Requests\Mission\LearningPathContentRequest;
use App\Http\Requests\Mission\MissionPathContentsRequest;
use App\Http\Requests\Mission\RearrangeMissionRequest;
use App\Http\Requests\Mission\UpdateMissionRequest;
use App\Responses\ApiResponse;
use App\Services\MissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    /**
     * __construct function
     *
     * @param MissionService $missionService
     * @param ApiResponse $apiResponse
     * @param Request $request
     */
    public function __construct(protected MissionService $missionService,protected ApiResponse $apiResponse,Request $request)
    {
        parent::__construct($request);
    }


    /**
     * index function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $missions = $this->missionService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all',
            'level_id'
        ]));
        return $this->apiResponse
            ->setData($missions['data'] ?? [])
            ->setMessages($missions['messages'] ?? [])
            ->setErrors($missions['errors'] ?? [])
            ->setCode($missions['code'])
            ->setMeta($missions['meta'])
            ->create();
    }


    /**
     * Show Item function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $response = $this->missionService->show($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function fullDetails(int $id): JsonResponse
    {
        $response = $this->missionService->fullDetails($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * Show Item function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function missionLearningPath(int $id): JsonResponse
    {
        $response = $this->missionService->missionLearningPath($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
    /**
     * Create Mission function
     *
     * @param CreateMissionRequest $createMissionRequest
     * @return JsonResponse
     */
    public function create(CreateMissionRequest $createMissionRequest): JsonResponse
    {
        ini_set('upload_max_filesize','2048M');
        ini_set('max_execution_time',600);
        ini_set('post_max_size','2048M');
        ini_set('memory_limit','2048M');

        $response = $this->missionService->create($createMissionRequest->validated());
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
     * @param UpdateMissionRequest $updateLevelRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateMissionRequest $updateMissionRequest): JsonResponse
    {
        $response = $this->missionService->update($updateMissionRequest->validated(), $id);
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
        $response = $this->missionService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

     /**
     * Duplicate function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function duplicateMission(int $id): JsonResponse
    {
        $response = $this->missionService->duplicateMission($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * Duplicate function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function rearrangeMissions(RearrangeMissionRequest $rearrangeMissionRequest): JsonResponse
    {
        $response = $this->missionService->rearrangeMissions($rearrangeMissionRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }


    /**
     * Mission LearningPath Content function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function missionLearningPathContent(MissionPathContentsRequest $missionPathContentsRequest): JsonResponse
    {
        $response = $this->missionService->missionLearningPathContent($missionPathContentsRequest->validated());

        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }


    /**
     * Handel LearningPath Content function
     *
     * @param LearningPathContentRequest $learningPathContentRequest
     * @return JsonResponse
     */
    public function handelLearningPathContent(LearningPathContentRequest $learningPathContentRequest): JsonResponse
    {
        $response = $this->missionService->handelLearningPathContent($learningPathContentRequest->validated());

        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
