<?php
namespace App\Http\Controllers;

use App\Http\Requests\LearningPath\CreateLearningPathRequest;
use App\Http\Requests\LearningPath\LearningpathManageStatusRequest;
use App\Http\Requests\LearningPath\UpdateLearningPathRequest;
use App\Responses\ApiResponse;
use App\Services\LearningPathService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LearningPathController extends Controller
{
    public function __construct(protected LearningPathService $learningPathService,protected ApiResponse $apiResponse){}
        /**
         * Index function
         *
         * @param Request $request
         * @return JsonResponse
         */
        public function index(Request $request): JsonResponse
        {
            $learningPaths = $this->learningPathService->getAll($request->only([
                'per_page',
                'page',
                'name',
                'order',
                'list_all',
                'mission_id'
            ]));
            return $this->apiResponse
                ->setData($learningPaths['data'] ?? [])
                ->setMessages($learningPaths['messages'] ?? [])
                ->setErrors($learningPaths['errors'] ?? [])
                ->setCode($learningPaths['code'])
                ->setMeta($learningPaths['meta'])
                ->create();
        }


        /**
         * Show function
         *
         * @param id $Id
         * @return JsonResponse
         */
        public function show(int $id): JsonResponse
        {
            $learningPath = $this->learningPathService->show($id);

            return $this->apiResponse
                ->setData($learningPath['data'] ?? [])
                ->setMessages($learningPath['messages'] ?? [])
                ->setErrors($learningPath['errors'] ?? [])
                ->setCode($learningPath['code'])
                ->create();
        }

         /**
         * Create function
         *
         * @param LearningpathManageStatusRequest $learningpathManageStatusRequest
         * @return JsonResponse
         */
        public function learningPathManageStatus(LearningpathManageStatusRequest $learningpathManageStatusRequest): JsonResponse
        {
            $response = $this->learningPathService->learningPathManageStatus($learningpathManageStatusRequest->validated());
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
         * @param CreateLearningPathRequest $createLearningPathRequest
         * @return JsonResponse
         */
        public function create(CreateLearningPathRequest $createLearningPathRequest): JsonResponse
        {
            $response = $this->learningPathService->create($createLearningPathRequest->validated());
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
         * @param UpdateLearningPathRequest $updateCountryRequest
         * @return JsonResponse
         */
        public function update(int $id,UpdateLearningPathRequest $updateCountryRequest): JsonResponse
        {
            $response = $this->learningPathService->update($updateCountryRequest->validated(), $id);


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
            $response = $this->learningPathService->delete($id);
            return $this->apiResponse
                ->setData($response['data'] ?? [])
                ->setMessages($response['messages'] ?? [])
                ->setErrors($response['errors'] ?? [])
                ->setCode($response['code'])
                ->create();
        }
    }
