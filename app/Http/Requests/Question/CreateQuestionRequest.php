<?php

namespace App\Http\Requests\Question;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateQuestionRequest extends BaseRequest
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
            'question' => 'required|string|max:10000000',
            'question_type_id' => 'required|integer|exists:question_types,id',
            'question_type_sub_id' => ['required','integer', Rule::exists('question_types','id')->where('parent_id',request()->question_type_id)],
            'question_difficulty_id' => 'required|integer|exists:question_difficulties,id',
            'language_skill_id' => 'required|integer|exists:language_skills,id',
            'bloom_category_id' => 'required|integer|exists:bloom_categories,id',
            'language_method_id' => 'required|integer|exists:language_methods,id',
            'learning_path_id'=> 'required|integer|exists:learning_paths,id',
            'level_id'=> 'required|integer|exists:levels,id',
            'answers.*' => 'required|array|min:1',
            'answers.*.answer' => 'required',
            'answers.*.correct' => 'nullable|in:1,0',
            'answers.*.order' => 'nullable|integer|distinct',
            'answers.*.audio' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            'answers.*.match_from' => 'nullable|in:1,0',
            'answers.*.answers_to.*' => 'nullable|array',
            'answers.*.answers_to.*.answer' => 'nullable',
            'answers.*.answers_to.*.match_to' => 'nullable',
            'answers.*.answers_to.*.audio' => 'nullable',
            'question_pattern' => 'required|in:image,text',
            'hint' => 'nullable|string|max:1000',
            'quiz_id'=>'nullable|exists:quizzes,id',
            'question_audio'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',

        ];
    }
}
