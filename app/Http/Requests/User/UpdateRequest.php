<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required','email',Rule::unique('users','email')->ignore($this->id)],
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => ['required', Rule::unique('users','mobile')->ignore($this->id)],
            'roles' => 'nullable|array|min:1',
            'roles.*' => [Rule::exists('id','roles')->where('system_role',1)],
            'password' => 'nullable|min:6',
            // 'logo_id' => 'nullable|exists:medias,id',
            // 'gender' => 'nullable|string',
            // 'description' => 'nullable|string',
            // 'coach_type' => 'nullable|string',
            // 'license_status' => 'nullable',
            // 'tags' => 'nullable|array',
            // 'tags.*' => 'integer'.
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_media' => 'required',


        ];
    }
}
