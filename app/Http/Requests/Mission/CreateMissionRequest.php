<?php

namespace App\Http\Requests\Mission;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CreateMissionRequest extends BaseRequest
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
            'country_id' => 'nullable|integer|exists:countries,id',
            'data_range' => 'required|integer',
            'mission_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'level_id' => 'nullable|integer|exists:levels,id',
            'term_id' => 'nullable|integer|exists:terms,id',
            'learningpaths' => 'required|array|min:1|max:3',
            'learningpaths.*.id' => 'nullable|exists:learning_paths,id',
            'learningpaths.*.videos' => 'nullable|array|min:1',
            // // 'learningpaths.*.videos.*.learning_path_id' => 'required|exists:learning_paths,id',
            'learningpaths.*.videos.*.id' => 'nullable|exists:video_banks,id',
            'learningpaths.*.videos.*.is_selected' => 'in:1,0',
            'learningpaths.*.videos.*.order' => ['required','integer'],
            'learningpaths.*.papersworks' => 'nullable|array|min:1',
            // 'learningpaths.*.papersworks.*.learning_path_id' => 'required|exists:learning_paths,id',
            'learningpaths.*.papersworks.*.id' => 'nullable|exists:peper_works,id',
            'learningpaths.*.papersworks.*.is_selected' => 'in:1,0',
            'learningpaths.*.papersworks.*.order' => ['required','integer'],
            'learningpaths.*.quizzes' => 'nullable|array|min:1',
            // 'learningpaths.*.quizzes.*.learning_path_id' => 'required|exists:learning_paths,id',
            'learningpaths.*.quizzes.*.id' => 'nullable|exists:quizzes,id',
            'learningpaths.*.quizzes.*.is_selected' => 'in:1,0',
            'learningpaths.*.quizzes.*.order' => ['nullable','integer'],
        ];
    }
}
