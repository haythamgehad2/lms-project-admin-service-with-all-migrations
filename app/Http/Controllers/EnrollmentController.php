<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enrollment\EnrollmentRequest;
use App\Http\Requests\Enrollment\EnrollmentSchoolAdminRequest;
use App\Http\Requests\Enrollment\EnrollmentStaffRequest;
use App\Http\Requests\Enrollment\ListSchoolAdminRequest;
use App\Http\Requests\Enrollment\UpdateEnrollmentRequest;
use App\Responses\ApiResponse;
use App\Services\EnrollmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{


    /**
     *
     *
     *
     * _Construct function
     *
     * @param EnrollmentService $enrollmentService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected EnrollmentService $enrollmentService,protected ApiResponse $apiResponse){}
    /**
     * Index function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $countries = $this->enrollmentService->getAll($request->only([
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
     * @param EnrollmentRequest $enrollmentRequest
     * @return JsonResponse
     */
    public function create(EnrollmentRequest $enrollmentRequest): JsonResponse
    {
        $response = $this->enrollmentService->create($enrollmentRequest->all());
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
     * @param UpdateEnrollmentRequest $updateClassRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateEnrollmentRequest $updateEnrollmentRequest): JsonResponse
    {
        $response = $this->enrollmentService->update($updateEnrollmentRequest->validated(), $id);
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
       $response = $this->enrollmentService->show($id);

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
     * @param EnrollmentStaffRequest $enrollmentStaffRequest
     * @return JsonResponse
     */
    public function getStaff(EnrollmentStaffRequest $enrollmentStaffRequest): JsonResponse
    {
        $response = $this->enrollmentService->getStaff($enrollmentStaffRequest->validated());
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
     * @param EnrollmentStaffRequest $enrollmentStaffRequest
     * @return JsonResponse
     */
    public function getCanSchoolOwner(Request $request): JsonResponse
    {
        $response = $this->enrollmentService->getCanSchoolOwner($request->all());
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
        $response = $this->enrollmentService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * Add School Admin function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function addSchoolAdmin(EnrollmentSchoolAdminRequest $enrollmentSchoolAdminRequest): JsonResponse
    {
        $response = $this->enrollmentService->addSchoolAdmin($enrollmentSchoolAdminRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

     /**
     * Remove School Admin function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function removeSchoolAdmin(EnrollmentSchoolAdminRequest $enrollmentSchoolAdminRequest): JsonResponse
    {
        $response = $this->enrollmentService->removeSchoolAdmin($enrollmentSchoolAdminRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
     /**
     * List School Admin function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function listSchoolAdmins(ListSchoolAdminRequest $listSchoolAdminRequest): JsonResponse
    {
        $response = $this->enrollmentService->listSchoolAdmins($listSchoolAdminRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }



}
