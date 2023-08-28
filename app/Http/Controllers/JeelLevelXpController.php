<?php

namespace App\Http\Controllers;

use App\Http\Requests\JeelLevelXp\UpdateJeelLevelRequest;
use App\Responses\ApiResponse;
use App\Services\JeelLevelXpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JeelLevelXpController extends Controller
{
    public function __construct(
        protected JeelLevelXpService $service,
        protected ApiResponse $apiResponse
    ) {}

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

    public function update(
        int $id,
        UpdateJeelLevelRequest $updateRequest
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
