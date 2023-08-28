<?php

namespace App\Http\Controllers;

use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UpdateVideoRequest;
use App\Responses\ApiResponse;
use App\Services\VideoBankService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoBankController extends Controller
{
    /**
     * Construction function
     *
     * @param VideoBankService $videoBankService
     * @param ApiResponse $apiResponse
     * @param Request $request
     */
    public function __construct(protected VideoBankService $videoBankService,protected ApiResponse $apiResponse,Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Index Or List function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $video = $this->videoBankService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'level_id',
            'term_id',
            'learning_path_id',
            'order',
            'list_all'
        ]));
        return $this->apiResponse
            ->setData($video['data'] ?? [])
            ->setMessages($video['messages'] ?? [])
            ->setErrors($video['errors'] ?? [])
            ->setCode($video['code'])
            ->setMeta($video['meta'])
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
        $response = $this->videoBankService->show($id);
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
     * @param CreateThemeRequest $createThemeRequest
     * @return JsonResponse
     */
    public function create(CreateVideoRequest $createVideoRequest): JsonResponse
    {
        // ini_set('upload_max_filesize', '1048M');
        // ini_set('max_execution_time', 600);
        // ini_set('post_max_size', '2048M');
        // ini_set('memory_limit','2048M');
        $response = $this->videoBankService->create($createVideoRequest->validated());
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
     * @param UpdateThemeRequest $updateThemeRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateVideoRequest $updateVideoRequest): JsonResponse
    {
        // ini_set('upload_max_filesize', '1048M');
        // ini_set('max_execution_time', 600);
        // ini_set('post_max_size', '2048M');
        // ini_set('memory_limit','2048M');
        $response = $this->videoBankService->update($updateVideoRequest->validated(), $id);
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
        $response = $this->videoBankService->delete($id);
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
    public function removeThumbnail(int $id): JsonResponse
    {
        $response = $this->videoBankService->removeThumbnail($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
