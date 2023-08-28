<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageSkill\CreateLanguageSkillRequest;
use App\Http\Requests\LanguageSkill\UpdateLanguageSkillRequest;
use App\Responses\ApiResponse;
use App\Services\LanguageSkillService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageSkillController extends Controller
{

    /**
     * _Construct function
     *
     * @param LanguageSkillService $languageSkillService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected LanguageSkillService $languageSkillService,protected ApiResponse $apiResponse){}


    /**
     * Get All function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $schoolGroups = $this->languageSkillService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all'
        ]));

        return $this->apiResponse
            ->setData($schoolGroups['data'] ?? [])
            ->setMessages($schoolGroups['messages'] ?? [])
            ->setErrors($schoolGroups['errors'] ?? [])
            ->setCode($schoolGroups['code'])
            ->setMeta($schoolGroups['meta'])
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
        $schoolGroups = $this->languageSkillService->show($id);

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
     * @param CreateLanguageSkillRequest $createLanguageSkillRequest
     * @return JsonResponse
     */
    public function create(CreateLanguageSkillRequest $createLanguageSkillRequest): JsonResponse
    {
        $response = $this->languageSkillService->create($createLanguageSkillRequest->validated());
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
     * @param UpdateLanguageSkillRequest $updateLanguageSkillRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateLanguageSkillRequest $updateLanguageSkillRequest): JsonResponse
    {
        $response = $this->languageSkillService->update($updateLanguageSkillRequest->validated(), $id);
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
        $response = $this->languageSkillService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
