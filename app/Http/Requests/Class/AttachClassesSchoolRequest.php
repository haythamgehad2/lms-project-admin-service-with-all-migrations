<?php

namespace App\Http\Requests\Term;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachClassesSchoolRequest extends BaseRequest
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
            'school_id' => ['required',Rule::exists('schools','id')],
            'level_term_id' => ['required',Rule::exists('level_terms','id')],
        ];
    }
}
