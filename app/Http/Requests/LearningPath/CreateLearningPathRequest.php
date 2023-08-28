<?php

namespace App\Http\Requests\LearningPath;
use App\Http\Requests\BaseRequest;

class CreateLearningPathRequest extends BaseRequest
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
            "name" => "required|string|min:3|max:1000",
            "description" => "required|string|min:3|max:1000",

        ];
    }
}
