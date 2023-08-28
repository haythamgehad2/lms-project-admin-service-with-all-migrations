<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\BaseRequest;

class UpdatePermissionRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3",
            "code" => "string|min:3"
        ];
    }
}
