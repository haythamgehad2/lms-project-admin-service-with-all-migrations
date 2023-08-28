<?php

namespace App\Http\Controllers;
use App\Http\Requests\Student\ClassStudentsRequest;
use App\Http\Requests\Student\CreateStudentClassRequest;
use App\Http\Requests\Student\UpdateStudentClassRequest;
use App\Responses\ApiResponse;
use App\Services\StudentClassService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{

    /**
     * _Construct function
     *
     * @param StudentClassService $enrollmentService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected StudentClassService $studentClassService,protected ApiResponse $apiResponse){}
        /**
         * Index function
         *
         * @param Request $request
         * @return JsonResponse
         */
        public function index(Request $request): JsonResponse
        {
            $countries = $this->studentClassService->getAll($request->only([
                'per_page',
                'page',
                'name',
                'order',
                'list_all',
                'school_id'
            ]));

            return $this->apiResponse
                ->setData($countries['data'] ?? [])
                ->setMessages($countries['messages'] ?? [])
                ->setErrors($countries['errors'] ?? [])
                ->setCode($countries['code'])
                ->setMeta($countries['meta'])
                ->create();
        }

        /**
         * Enrollment function
         *
         * @param CreateStudentClassRequest $createStudentClassRequest
         * @return JsonResponse
         */
        public function create(CreateStudentClassRequest $createStudentClassRequest): JsonResponse
        {
            $response = $this->studentClassService->create($createStudentClassRequest->all());
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
         * @param UpdateStudentClassRequest $updateStudentClassRequest
         * @return JsonResponse
         */
        public function update(int $id,UpdateStudentClassRequest $updateStudentClassRequest): JsonResponse
        {
            $response = $this->studentClassService->update($updateStudentClassRequest->validated(), $id);
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
        * @param  int $id
        * @return JsonResponse
        */
       public function show(int $id): JsonResponse
       {
           $response = $this->studentClassService->show($id);

           return $this->apiResponse
               ->setData($response['data'] ?? [])
               ->setMessages($response['messages'] ?? [])
               ->setErrors($response['errors'] ?? [])
               ->setCode($response['code'])
               ->create();
       }

        /**
         * Enrollment function
         *
         * @param ClassStudentsRequest $classStudentsRequest
         * @return JsonResponse
         */
        public function getStudents(ClassStudentsRequest $classStudentsRequest): JsonResponse
        {
            $response = $this->studentClassService->getStudents($classStudentsRequest->validated());
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
            $response = $this->studentClassService->delete($id);
            return $this->apiResponse
                ->setData($response['data'] ?? [])
                ->setMessages($response['messages'] ?? [])
                ->setErrors($response['errors'] ?? [])
                ->setCode($response['code'])
                ->create();
        }
    }
