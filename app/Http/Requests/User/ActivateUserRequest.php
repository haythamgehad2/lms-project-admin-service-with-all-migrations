<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class ActivateUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
}
