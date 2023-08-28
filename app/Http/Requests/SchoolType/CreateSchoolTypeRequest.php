<?php

namespace App\Http\Requests\SchoolType;

use App\Http\Requests\BaseRequest;

class CreateSchoolTypeRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3"
        ];
    }
}
