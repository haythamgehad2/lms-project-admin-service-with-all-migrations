<?php

namespace App\Http\Requests\Quiz;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateQuizRequest extends BaseRequest
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
        return[
            'name' => 'required|string|min:3|max:1000',
            'description' => 'required|string|min:3|max:1000',
            'total_question' => 'required|integer',
            'type' => 'required|in:default,manual,automatic',
            'learning_path_id' => 'required|integer|exists:learning_paths,id',
            'level_id' => 'required|integer|exists:levels,id',
            'term_id'=> ['required',Rule::exists('level_terms','term_id')->where('level_id',request()->level_id)],
            'questions' => 'required|array',
            'questions.*' => ['required',Rule::exists('questions','id')->where('learning_path_id',request()->learning_path_id)->where('level_id',request()->level_id)],
            'total_grade' => "nullable|integer|min:1|max:10000000",
            'success_grade' => "nullable|integer|min:1|max:10000000",
            'calc_type' => "nullable|in:max,average",
        ];
    }
}
