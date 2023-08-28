<?php

namespace App\Http\Controllers;

use App\Http\Requests\RewardAction\UpdateRewardActionRequest;
use App\Responses\ApiResponse;
use App\Services\RewardActionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RewardActionController extends Controller
{
    public function __construct(
        protected RewardActionService $service,
        protected ApiResponse $apiResponse
    ) {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse {
        $rewardActions = $this->service->getPaginated($request->only(['per_page', 'page','order','name',
        'list_all']));

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

    public function update(
        int $id,
        UpdateRewardActionRequest $updateRequest
    ) : JsonResponse {
        $response = $this->service->update($updateRequest->validated(), $id);

        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
