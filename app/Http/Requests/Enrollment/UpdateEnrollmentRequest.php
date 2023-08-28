<?php

namespace App\Http\Requests\Enrollment;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnrollmentRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "user_id"   => ['required',Rule::exists('users','id')],
            "school_id" => ['required',Rule::exists('schools','id')],
            "class_id"  => ['required',Rule::exists('classes','id')->where('school_id',request()->school_id)->whereNotNull('level_term_id')],
            "level_id"  => ['required',Rule::exists('levels','id')->where('school_id',request()->school_id)],
            "role_id"   => ['required',Rule::exists('roles','id')->where('system_role',0)]
        ];
    }
}
