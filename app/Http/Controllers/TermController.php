<?php

namespace App\Http\Controllers;

use App\Http\Requests\Term\CreateTermRequest;
use App\Http\Requests\Term\UpdateTermRequest;
use App\Models\Term;
use App\Responses\ApiResponse;
use App\Services\TermService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function __construct(protected TermService $termService,protected ApiResponse $apiResponse)
    {}

    public function index(Request $request): JsonResponse
    {
        $terms = $this->termService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'school_id',
            'order',
            'list_all',
            'level_id'

        ]));

        return $this->apiResponse
            ->setData($terms['data'] ?? [])
            ->setMessages($terms['messages'] ?? [])
            ->setErrors($terms['errors'] ?? [])
            ->setCode($terms['code'])
            ->setMeta($terms['meta'])
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
        $response = $this->termService->show($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
    /**
     * Create function
     *
     * @param CreateTermRequest $createTermRequest
     * @return JsonResponse
     */
    public function create(CreateTermRequest $createTermRequest): JsonResponse
    {
        $response = $this->termService->create($createTermRequest->validated());
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
     * @param UpdateTermRequest $updateTermRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateTermRequest $updateTermRequest): JsonResponse
    {
        $response = $this->termService->update($updateTermRequest->validated(), $id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * delete function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $response = $this->termService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
