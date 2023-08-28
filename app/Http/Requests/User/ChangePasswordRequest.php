<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ];
    }
}
