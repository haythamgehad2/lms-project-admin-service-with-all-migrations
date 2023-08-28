<?php

namespace App\Http\Requests;

use App\Responses\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class BaseRequest extends FormRequest
{
    /**
     * Response variable
     *
     * @var [type]
     */
    public $response;
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->response = new ApiResponse;
    }
    /**
     * Failed Validation function
     *
     * @param Validator $validator
     * @return object
     */
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            $this->response->setCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->setErrors($validator->errors()->all())
                ->setData([])
                ->create()
        );
    }
}
