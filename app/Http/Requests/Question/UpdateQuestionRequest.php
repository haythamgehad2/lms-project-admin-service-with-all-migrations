<?php

namespace App\Http\Requests\Question;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends BaseRequest
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
            'language_skill_id' => 'required|integer|exists:language_skills,id',
            'bloom_category_id' => 'required|integer|exists:bloom_categories,id',
            'language_method_id' => 'required|integer|exists:language_methods,id',
            'question_difficulty_id' => 'required|integer|exists:question_difficulties,id',
            'learning_path_id'=> 'required|integer|exists:learning_paths,id',
            'level_id'=> 'required|integer|exists:levels,id',
            'answers.*' => 'required|array|min:1',
            // 'answers.*.id' => ['required','integer',Rule::exists('question_answers','id')->where('question_id',$this->id)],
            'answers.*.answer' => 'required|string',
            'answers.*.correct' => 'required|in:1,0',
            'answers.*.audio' => 'nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            'question_pattern' => 'required|in:image,text',
            'hint' => 'nullable|string|max:1000',
            'question_audio'=>'nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',


        ];
    }
}
