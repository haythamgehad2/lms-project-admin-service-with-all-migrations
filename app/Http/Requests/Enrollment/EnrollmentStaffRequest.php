<?php

namespace App\Http\Requests\Enrollment;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnrollmentStaffRequest extends BaseRequest
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
            "name"   => ['nullable','string'],
            "email"   => ['nullable','string'],
            "school_id" => ['required',Rule::exists('schools','id')],

        ];
    }
}
