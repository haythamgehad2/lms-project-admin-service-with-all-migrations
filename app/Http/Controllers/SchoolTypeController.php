<?php
namespace App\Http\Controllers;
use App\Http\Requests\SchoolType\CreateSchoolTypeRequest;
use App\Http\Requests\SchoolType\UpdateSchoolTypeRequest;
use App\Models\SchoolType;
use App\Responses\ApiResponse;
use App\Services\SchoolTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolTypeController extends Controller
{

    /**
     * __construct function
     *
     * @param SchoolTypeService $schoolTypeService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected SchoolTypeService $schoolTypeService,protected ApiResponse $apiResponse){}

    /**
     * index function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $schoolTypes = $this->schoolTypeService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all'
        ]));
        return $this->apiResponse
            ->setData($schoolTypes['data'] ?? [])
            ->setMessages($schoolTypes['messages'] ?? [])
            ->setErrors($schoolTypes['errors'] ?? [])
            ->setCode($schoolTypes['code'])
            ->setMeta($schoolTypes['meta'])
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
        $schoolTypes = $this->schoolTypeService->show($id);

        return $this->apiResponse
            ->setData($schoolTypes['data'] ?? [])
            ->setMessages($schoolTypes['messages'] ?? [])
            ->setErrors($schoolTypes['errors'] ?? [])
            ->setCode($schoolTypes['code'])
            ->create();
    }

    /**
     * Create function
     *
     * @param CreateSchoolTypeRequest $createSchoolTypeRequest
     * @return JsonResponse
     */
    public function create(CreateSchoolTypeRequest $createSchoolTypeRequest): JsonResponse
    {
        $response = $this->schoolTypeService->create($createSchoolTypeRequest->all());
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
     * @param UpdateSchoolTypeRequest $updateSchoolTypeRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateSchoolTypeRequest $updateSchoolTypeRequest): JsonResponse
    {
        $response = $this->schoolTypeService->update($updateSchoolTypeRequest->all(), $id);
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
        $response = $this->schoolTypeService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
