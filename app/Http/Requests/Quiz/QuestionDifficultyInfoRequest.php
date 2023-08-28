<?php
namespace App\Http\Requests\Quiz;
use App\Http\Requests\BaseRequest;

class QuestionDifficultyInfoRequest extends BaseRequest
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
            'level_id' => 'required|integer|exists:levels,id',
            'learning_path_id' => 'required|integer|exists:learning_paths,id',
        ];
    }
}
