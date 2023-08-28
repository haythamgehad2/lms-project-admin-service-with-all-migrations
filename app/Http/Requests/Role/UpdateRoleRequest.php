<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseRequest;

class UpdateRoleRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3",
            "code" => "string|min:3",
            "description" => "string|min:3",
            "permission" => "nullable|array",
            "permission.*" => "exists:permissions,id"
        ];
    }
}
