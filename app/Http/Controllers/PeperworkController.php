<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeperWork\CreatePeperworkRequest;
use App\Http\Requests\PeperWork\UpdatePeperworkRequest;
use App\Responses\ApiResponse;
use App\Services\PeperworkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeperworkController extends Controller
{
    /**
     * __construct function
     *
     * @param PeperworkService $peperworkService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected PeperworkService $peperworkService,protected ApiResponse $apiResponse){}
        /**
         * index function
         *
         * @param Request $request
         * @return JsonResponse
         */
        public function index(Request $request): JsonResponse
        {
            $peperworks = $this->peperworkService->getAll($request->only([
                'per_page',
                'page',
                'name',
                'order',
                'list_all',
                'level_id',
                'term_id',
                'learning_path_id'
            ]));
            return $this->apiResponse
                ->setData($peperworks['data'] ?? [])
                ->setMessages($peperworks['messages'] ?? [])
                ->setErrors($peperworks['errors'] ?? [])
                ->setCode($peperworks['code'])
                ->setMeta($peperworks['meta'])
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
            $peperwork = $this->peperworkService->show($id);

            return $this->apiResponse
                ->setData($peperwork['data'] ?? [])
                ->setMessages($peperwork['messages'] ?? [])
                ->setErrors($peperwork['errors'] ?? [])
                ->setCode($peperwork['code'])
                ->create();
        }

        /**
         * Create function
         *
         * @param CreatePeperworkRequest $preatePeperworkRequest
         * @return JsonResponse
         */
        public function create(CreatePeperworkRequest $preatePeperworkRequest): JsonResponse
        {
            $response = $this->peperworkService->create($preatePeperworkRequest->validated());
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
         * @param UpdatePeperworkRequest $updatePeperworkRequest
         * @return JsonResponse
         */
        public function update(int $id,UpdatePeperworkRequest $updatePeperworkRequest): JsonResponse
        {
            $response = $this->peperworkService->update($updatePeperworkRequest->validated(), $id);
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
            $response = $this->peperworkService->delete($id);
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
        public function deleteFile(int $id): JsonResponse
        {
            $response = $this->peperworkService->deleteFile($id);
            return $this->apiResponse
                ->setData($response['data'] ?? [])
                ->setMessages($response['messages'] ?? [])
                ->setErrors($response['errors'] ?? [])
                ->setCode($response['code'])
                ->create();

        }

    }
