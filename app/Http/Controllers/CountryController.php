<?php

namespace App\Http\Controllers;

use App\Http\Requests\Country\CreateCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Models\Country;
use App\Responses\ApiResponse;
use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(protected CountryService $countryService,protected ApiResponse $apiResponse){}


    /**
     * Index function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $countries = $this->countryService->getAll($request->only([
            'per_page',
            'page',
            'name',
            'order',
            'list_all'
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
     * Show function
     *
     * @param CreateSchoolGroupRequest $createSchoolGroupRequest
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $countries = $this->countryService->show($id);

        return $this->apiResponse
            ->setData($countries['data'] ?? [])
            ->setMessages($countries['messages'] ?? [])
            ->setErrors($countries['errors'] ?? [])
            ->setCode($countries['code'])
            ->create();
    }
    /**
     * Create function
     *
     * @param CreateCountryRequest $createCountryRequest
     * @return JsonResponse
     */
    public function create(CreateCountryRequest $createCountryRequest): JsonResponse
    {
        $response = $this->countryService->create($createCountryRequest->all());
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
     * @param UpdateCountryRequest $updateCountryRequest
     * @return JsonResponse
     */
    public function update(int $id,UpdateCountryRequest $updateCountryRequest): JsonResponse
    {
        $response = $this->countryService->update($updateCountryRequest->all(), $id);
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
        $response = $this->countryService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
