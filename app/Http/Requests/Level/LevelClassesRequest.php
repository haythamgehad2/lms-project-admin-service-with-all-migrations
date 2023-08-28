<?php
namespace App\Http\Requests\Level;
use App\Http\Requests\BaseRequest;

class LevelClassesRequest extends BaseRequest
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
            'level_id' => 'nullable|exists:level_terms,level_id',
        ];
    }
}
