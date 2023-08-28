<?php

namespace App\Http\Requests\Mission;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class MissionPathContentsRequest extends BaseRequest
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
        ];
    }
}
