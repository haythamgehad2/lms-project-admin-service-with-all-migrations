<?php

namespace App\Http\Requests\QuestionDifficulty;

use App\Enums\QuestionDifficultyTypes;
use App\Http\Requests\BaseRequest;

class CreateQuestionDifficultyRequest extends BaseRequest
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
            'name' => 'required|string|min:3',
            'slug' => 'required|string|min:3|unique:question_difficulties,slug|in:'. QuestionDifficultyTypes::getTypes()->implode(","),
            'xp' => 'nullable|intger|min:1',
            'coins' => 'nullable|intger|min:1',

        ];
    }
}
