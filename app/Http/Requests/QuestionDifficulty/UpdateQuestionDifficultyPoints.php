<?php

namespace App\Http\Requests\QuestionDifficulty;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionDifficultyPoints extends FormRequest
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
            "grade_points" => "required|integer|min:0|max:1000000"
        ];
    }
}
