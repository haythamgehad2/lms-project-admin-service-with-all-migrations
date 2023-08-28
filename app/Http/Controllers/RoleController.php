<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\ListRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Responses\ApiResponse;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService,protected ApiResponse $apiResponse,Request $request)
    {
        parent::__construct($request);
    }


    /**
     * Index function
     *
     * @param ListRoleRequest $request
     * @return JsonResponse
     */
    public function index(ListRoleRequest $request): JsonResponse
    {

        $roles = $this->roleService->getAll($request->validated());

        return $this->apiResponse
            ->setData($roles['data'] ?? [])
            ->setMessages($roles['messages'] ?? [])
            ->setErrors($roles['errors'] ?? [])
            ->setCode($roles['code'])
            ->setMeta($roles['meta'])
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
        $response = $this->roleService->show($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    public function create(CreateRoleRequest $createRoleRequest): JsonResponse
    {
        $response = $this->roleService->create($createRoleRequest->validated());
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
     * @param UpdateRoleRequest $updateRoleRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateRoleRequest $updateRoleRequest): JsonResponse
    {
        $response = $this->roleService->update($updateRoleRequest->all(), $id);
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
        $response = $this->roleService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
