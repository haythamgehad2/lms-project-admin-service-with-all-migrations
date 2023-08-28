<?php
namespace App\Http\Controllers;
use App\Http\Requests\Level\AttachLevelsSchoolRequest;
use App\Http\Requests\Level\CreateLevelRequest;
use App\Http\Requests\Level\UpdateLevelRequest;
use App\Models\Level;
use App\Responses\ApiResponse;
use App\Services\LevelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function __construct(protected LevelService $levelService,protected ApiResponse $apiResponse,Request $request)
    {
        parent::__construct($request);
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $levels = $this->levelService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all',
            'field_sort_by',
            'school_id'
        ]));
        return $this->apiResponse
            ->setData($levels['data'] ?? [])
            ->setMessages($levels['messages'] ?? [])
            ->setErrors($levels['errors'] ?? [])
            ->setCode($levels['code'])
            ->setMeta($levels['meta'])
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
        $response = $this->levelService->show($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
    /**
     * Undocumented function
     *
     * @param CreateLevelRequest $createLevelRequest
     * @return JsonResponse
     */
    public function create(CreateLevelRequest $createLevelRequest): JsonResponse
    {
        $response = $this->levelService->create($createLevelRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    public function update(int $id,UpdateLevelRequest $updateLevelRequest): JsonResponse
    {
        $response = $this->levelService->update($updateLevelRequest->validated(), $id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    public function delete(int $id): JsonResponse
    {
        $response = $this->levelService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

   /**
     * Show Item function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function showSchoolLevels(int $id): JsonResponse
    {
        $response = $this->levelService->showSchoolLevels($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }


}
