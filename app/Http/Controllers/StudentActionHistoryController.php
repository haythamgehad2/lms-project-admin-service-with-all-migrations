<?php

namespace App\Http\Controllers;

use App\Responses\ApiResponse;
use App\Services\StudentActionHistoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentActionHistoryController extends Controller
{
    public function __construct(
        protected StudentActionHistoryService $service,
        protected ApiResponse $apiResponse
    ) {}

    /**
     * @param Request $request
     * @param integer $studentId
     * @return JsonResponse
     */
    public function studentIndex(Request $request, int $studentId) : JsonResponse {
        $options = $request->only(['per_page', 'page', 'order',]);
        $options['student_id'] = $studentId;

        $rewardActions = $this->service->getPaginated($options);

        return $this->apiResponse
            ->setData($rewardActions['data'] ?? [])
            ->setMessages($rewardActions['messages'] ?? [])
            ->setErrors($rewardActions['errors'] ?? [])
            ->setCode($rewardActions['code'])
            ->setMeta($rewardActions['meta'])
            ->create();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse {
        $rewardActions = $this->service->getPaginated($request->only(['per_page', 'page', 'order',]));

        return $this->apiResponse
            ->setData($rewardActions['data'] ?? [])
            ->setMessages($rewardActions['messages'] ?? [])
            ->setErrors($rewardActions['errors'] ?? [])
            ->setCode($rewardActions['code'])
            ->setMeta($rewardActions['meta'])
            ->create();
    }

    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse {
        $rewardAction = $this->service->show($id);

        return $this->apiResponse
            ->setData($rewardAction['data'] ?? [])
            ->setMessages($rewardAction['messages'] ?? [])
            ->setErrors($rewardAction['errors'] ?? [])
            ->setCode($rewardAction['code'])
            ->create();
    }
}
