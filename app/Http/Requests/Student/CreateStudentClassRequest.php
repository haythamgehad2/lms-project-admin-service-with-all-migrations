<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStudentClassRequest extends BaseRequest
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
        ];
    }
}
