<?php

namespace App\Http\Requests\RewardAction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRewardActionRequest extends FormRequest
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
            'action_name' => 'required|string|min:3|max:250',
            'action_desc' => 'required|string|min:3|max:250',
            'max_trail' => 'nullable|integer|min:1',
            'jeel_coins' => 'required|integer|min:0',
            'second_jeel_coins' => 'nullable|integer|min:0',
            'next_jeel_coins' => 'nullable|integer|min:0',
            'jeel_xp' => 'required|integer|min:0',
            'second_jeel_xp' => 'nullable|integer|min:0',
            'next_jeel_xp' => 'nullable|integer|min:0',
        ];
    }
}
