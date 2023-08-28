<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Responses\ApiResponse;
use App\Services\ThemeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Construction function
     *
     * @param ThemeService $themeService
     * @param ApiResponse $apiResponse
     * @param Request $request
     */
    public function __construct(protected ThemeService $themeService,protected ApiResponse $apiResponse,Request $request)
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
        $themes = $this->themeService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all'
        ]));
        return $this->apiResponse
            ->setData($themes['data'] ?? [])
            ->setMessages($themes['messages'] ?? [])
            ->setErrors($themes['errors'] ?? [])
            ->setCode($themes['code'])
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
        $response = $this->themeService->show($id);
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
    public function create(CreateThemeRequest $createThemeRequest): JsonResponse
    {
        $response = $this->themeService->create($createThemeRequest->all());
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
    public function update(int $id,UpdateThemeRequest $updateThemeRequest): JsonResponse
    {
        $response = $this->themeService->update($updateThemeRequest->all(), $id);
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
        $response = $this->themeService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
