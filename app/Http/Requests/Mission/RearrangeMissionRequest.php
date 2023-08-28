<?php

namespace App\Http\Requests\Mission;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RearrangeMissionRequest extends BaseRequest
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
            'level_id'     => 'required|integer|exists:levels,id',
            'missions'     => 'required|array',
            'missions.*.id' => ['required',Rule::exists('missions','id')->where('level_id',request()->level_id)],
            'missions.*.order' => ['required','integer','distinct'],
            'missions.*.start_date' => 'required|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
            'missions.*.end_date' => 'required|date|date_format:Y-m-d|after_or_equal:missions.*.start_date',
            'missions.*.is_selected' => ['required','in:1,0'],
        ];
    }
}
