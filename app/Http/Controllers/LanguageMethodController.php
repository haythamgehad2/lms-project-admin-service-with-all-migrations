<?php
namespace App\Http\Controllers;
use App\Http\Requests\LanguageMethod\CreateLanguageMethodRequest;
use App\Http\Requests\LanguageMethod\UpdateLanguageMethodRequest;
use App\Responses\ApiResponse;
use App\Services\LanguageMethodService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageMethodController extends Controller
{

    /**
     * _Construct function
     *
     * @param QuestionTypeService $languageMethodService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected LanguageMethodService $languageMethodService,protected ApiResponse $apiResponse){}


    /**
     * Get All function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $schoolGroups = $this->languageMethodService->getAll($request->only([
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
        $schoolGroups = $this->languageMethodService->show($id);

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
     * @param CreateLanguageMethodRequest $createLanguageMethodRequest
     * @return JsonResponse
     */
    public function create(CreateLanguageMethodRequest $createLanguageMethodRequest): JsonResponse
    {
        $response = $this->languageMethodService->create($createLanguageMethodRequest->validated());
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
     * @param UpdateLanguageMethodRequest $updateLanguageMethodRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateLanguageMethodRequest $updateLanguageMethodRequest): JsonResponse
    {
        $response = $this->languageMethodService->update($updateLanguageMethodRequest->validated(), $id);
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
        $response = $this->languageMethodService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
