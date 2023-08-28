<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Responses\ApiResponse;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(protected PermissionService $permissionService,protected ApiResponse $apiResponse,Request $request)
    {
        parent::__construct($request);
    }


    public function index(Request $request): JsonResponse
    {
        $permissions = $this->permissionService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all'
        ]));
        return $this->apiResponse
            ->setData($permissions['data'] ?? [])
            ->setMessages($permissions['messages'] ?? [])
            ->setErrors($permissions['errors'] ?? [])
            ->setCode($permissions['code'])
            ->create();
    }


    public function create(CreatePermissionRequest $createPermissionRequest): JsonResponse
    {
        $response = $this->permissionService->create($createPermissionRequest->all());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    public function update(int $id,UpdatePermissionRequest $updatePermissionRequest): JsonResponse
    {
        $response = $this->permissionService->update($updatePermissionRequest->all(), $id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    public function delete(int $id): JsonResponse
    {
        $response = $this->permissionService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
