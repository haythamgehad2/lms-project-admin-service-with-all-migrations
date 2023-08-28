<?php
namespace App\Http\Requests\Mission;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LearningPathContentRequest extends BaseRequest
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
            'learningpath_id' => 'required|integer|exists:learning_paths,id',
            'mission_id'      => 'required|integer|exists:missions,id',
            'videos'          => ['required',Rule::exists('mission_videos','video_bank_id')->where('learning_path_id',request()->learningpath_id)->where('mission_id',request()->mission_id)],
            'papersworks'     => ['required',Rule::exists('mission_paper_works','peper_work_id')->where('learning_path_id',request()->learningpath_id)->where('mission_id',request()->mission_id)],
            'quizzes'         => 'required|array',
            'quizzes.*.id'    => ['required',Rule::exists('mission_quizzes','quiz_id')->where('learning_path_id',request()->learningpath_id)->where('mission_id',request()->mission_id)],
            'quizzes.*.questions.*'=> ['required',Rule::exists('quiz_contents','question_id')],

        ];
    }
}
