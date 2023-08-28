<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'roles' => 'nullable|array|min:1',
            'roles.*' => [Rule::exists('id','roles')->where('system_role',1)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_media' => 'required',
        ];
    }
}
