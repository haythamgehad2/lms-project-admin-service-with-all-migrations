<?php

namespace App\Http\Requests\Quiz;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuizRequest extends BaseRequest
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
            'name' => 'required|string|min:3|max:1000',
            'description' => 'required|string|min:3|max:1000',
            'total_question' => 'required|integer',
            'type' => 'required|in:default,manual',
            'learning_path_id' => 'required|integer|exists:learning_paths,id',
            'level_id' => 'required|integer|exists:levels,id',
            'questions' => 'required|array',
            'questions.*' => 'exists:questions,id',
            'term_id'=> ['required',Rule::exists('level_terms','term_id')->where('level_id',request()->level_id)],
            // 'question_defficulties' => 'required_if:type,default|array|min:1',
            // 'question_defficulties.*.id' => 'required_with:question_defficulties|exists:question_difficulties,id',
            // 'question_defficulties.*.questions_count' => 'required_with:question_defficulties|integer',
            'total_grade' => "nullable|integer|min:1|max:10000000",
            'success_grade' => "nullable|integer|min:1|max:10000000",
            'calc_type' => "nullable|in:max,average",
        ];
    }
}
