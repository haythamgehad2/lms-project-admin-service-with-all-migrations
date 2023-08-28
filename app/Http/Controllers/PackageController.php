<?php

namespace App\Http\Controllers;

use App\Http\Requests\Package\CreatePackageRequest;
use App\Http\Requests\Package\UpdatePackageRequest;
use App\Models\Package;
use App\Responses\ApiResponse;
use App\Services\PackageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct(protected PackageService $packageService,protected ApiResponse $apiResponse,Request $request)
    {
        parent::__construct($request);
    }
    /**
     * Index function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $packages = $this->packageService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all'
        ]));
        return $this->apiResponse
            ->setData($packages['data'] ?? [])
            ->setMessages($packages['messages'] ?? [])
            ->setErrors($packages['errors'] ?? [])
            ->setCode($packages['code'])
            ->setMeta($packages['meta'])
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
        $schoolGroups = $this->packageService->show($id);

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
     * @param CreatePackageRequest $createPackageRequest
     * @return JsonResponse
     */
    public function create(CreatePackageRequest $createPackageRequest): JsonResponse
    {
        $response = $this->packageService->create($createPackageRequest->all());
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
     * @param UpdatePackageRequest $updatePackageRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdatePackageRequest $updatePackageRequest): JsonResponse
    {
        $response = $this->packageService->update($updatePackageRequest->all(), $id);
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
        $response = $this->packageService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
