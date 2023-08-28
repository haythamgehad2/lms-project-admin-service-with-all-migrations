<?php

namespace App\Http\Requests\Quiz;

use App\Http\Requests\BaseRequest;

class QuizRandomQuestionRequest extends BaseRequest
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
            'level_id' => 'required|exists:levels,id',
            'learning_path_id' => 'required|exists:learning_paths,id',
            'question_difficuly.*' => 'required|array|min:1',
            'question_difficuly.*.question_difficulty_id' => 'required|exists:question_difficulties,id',
            'question_difficuly.*.questions_count' => 'required|integer',
        ];
    }
}
