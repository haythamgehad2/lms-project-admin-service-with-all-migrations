<?php

namespace App\Http\Requests\LearningPath;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LearningpathManageStatusRequest extends BaseRequest
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
            'mission_id' => ['required',Rule::exists('mission_learningpaths','mission_id')->where('learning_path_id',request()->learningpath_id)],
            'learningpath_id' => ['required',Rule::exists('mission_learningpaths','learning_path_id')->where('mission_id',request()->mission_id)],
            'is_selected' => ['required','in:1,0'],

        ];
    }
}
