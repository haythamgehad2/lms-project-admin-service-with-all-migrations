<?php

namespace App\Http\Controllers;

use App\Http\Requests\Level\AttachLevelsSchoolRequest;
use App\Http\Requests\Level\LevelClassesRequest;
use App\Http\Requests\School\CreateSchoolRequest;
use App\Http\Requests\School\UpdateSchoolRequest;
use App\Http\Requests\Term\AttachClassesSchoolRequest;
use App\Http\Requests\Term\AttachTermsSchoolRequest;
use App\Models\School;
use App\Responses\ApiResponse;
use App\Services\SchoolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * SchoolService function
     *
     * @param SchoolService $schoolService
     * @param ApiResponse $apiResponse
     * @param Request $request
     */
    public function __construct(protected SchoolService $schoolService,protected ApiResponse $apiResponse,Request $request)
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
        $schools = $this->schoolService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all'
        ]));
        return $this->apiResponse
            ->setData($schools['data'] ?? [])
            ->setMessages($schools['messages'] ?? [])
            ->setErrors($schools['errors'] ?? [])
            ->setCode($schools['code'])
            ->setMeta($schools['meta'])
            ->create();
    }

    /**
     * Show function
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $schoolTypes = $this->schoolService->show($id);

        return $this->apiResponse
            ->setData($schoolTypes['data'] ?? [])
            ->setMessages($schoolTypes['messages'] ?? [])
            ->setErrors($schoolTypes['errors'] ?? [])
            ->setCode($schoolTypes['code'])
            ->create();
    }

      /**
     * Show function
     *
     * @param int $id
     * @return JsonResponse
     */
    public function mySchoolInfoResource(): JsonResponse
    {
        $schoolTypes = $this->schoolService->mySchoolInfoResource();

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
     * @param CreateSchoolRequest $createSchoolRequest
     * @return JsonResponse
     */
    public function create(CreateSchoolRequest $createSchoolRequest): JsonResponse
    {
        $response = $this->schoolService->create($createSchoolRequest->validated());
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
     * @param UpdateSchoolRequest $updateSchoolRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateSchoolRequest $updateSchoolRequest): JsonResponse
    {
        $response = $this->schoolService->update($updateSchoolRequest->validated(), $id);
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
        $response = $this->schoolService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * Attach SchoolLevels function
     *
     * @param AttachLevelsSchoolRequest $attachLevelsSchoolRequest
     * @return JsonResponse
     */
    public function schoolLevels(AttachLevelsSchoolRequest $attachLevelsSchoolRequest): JsonResponse
    {
        $response = $this->schoolService->schoolLevels($attachLevelsSchoolRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * Attach SchoolLevels function
     *
     * @param AttachTermsSchoolRequest $attachTermSchoolRequest
     * @return JsonResponse
     */
    public function schoolTerms(AttachTermsSchoolRequest $attachTermSchoolRequest): JsonResponse
    {
        $response = $this->schoolService->schoolTerms($attachTermSchoolRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * Attach SchoolClass function
     *
     * @param AttachClassesSchoolRequest $attachClassesSchoolRequest
     * @return JsonResponse
     */
    public function schoolClasses(AttachClassesSchoolRequest $attachClassesSchoolRequest): JsonResponse
    {
        $response = $this->schoolService->schoolClasses($attachClassesSchoolRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
    /**
     * Attach SchoolClass function
     *
     * @param LevelClassesRequest $levelClassesRequest
     * @return JsonResponse
     */
    public function schoolLevelTerm(LevelClassesRequest $levelClassesRequest,int $id): JsonResponse
    {
        $response = $this->schoolService->schoolLevelTerm($levelClassesRequest->validated(),$id);

        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    // /**
    //  * Show function
    //  *
    //  * @param int $id
    //  * @return JsonResponse
    //  */
    // public function mySchoolInfo(Request $request): JsonResponse
    // {
    //     $schoolTypes = $this->schoolService->mySchoolInfo($id);

    //     return $this->apiResponse
    //         ->setData($schoolTypes['data'] ?? [])
    //         ->setMessages($schoolTypes['messages'] ?? [])
    //         ->setErrors($schoolTypes['errors'] ?? [])
    //         ->setCode($schoolTypes['code'])
    //         ->create();
    // }


}
