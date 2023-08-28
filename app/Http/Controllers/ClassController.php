<?php

namespace App\Http\Controllers;

use App\Http\Requests\Class\CreateClassRequest;
use App\Http\Requests\Class\UpdateClassRequest;
use App\Responses\ApiResponse;
use App\Services\ClassService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct(protected ClassService $classService,protected ApiResponse $apiResponse)
    {}


    public function index(Request $request): JsonResponse
    {
        $classes = $this->classService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'school_id',
            'order',
            'list_all',
            'level_id'
        ]));

        return $this->apiResponse
            ->setData($classes['data'] ?? [])
            ->setMessages($classes['messages'] ?? [])
            ->setErrors($classes['errors'] ?? [])
            ->setCode($classes['code'])
            ->setMeta($classes['meta'])
            ->create();
    }


    /**
     * Create function
     *
     * @param CreateClassRequest $createClassRequest
     * @return JsonResponse
     */
    public function create(CreateClassRequest $createClassRequest): JsonResponse
    {
        $response = $this->classService->create($createClassRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * Updated function
     *
     * @param integer $id
     * @param UpdateClassRequest $updateClassRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateClassRequest $updateClassRequest): JsonResponse
    {
        $response = $this->classService->update($updateClassRequest->validated(), $id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
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
       $response = $this->classService->show($id);

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
        $response = $this->classService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
