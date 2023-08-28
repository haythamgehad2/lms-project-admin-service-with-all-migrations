<?php

namespace App\Http\Requests\Package;

use App\Http\Requests\BaseRequest;

class CreatePackageRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3",
            "price" => "required|integer",
            "description" => "required|string|min:20",
            "classes_count" => "required|integer",
        ];
    }
}
