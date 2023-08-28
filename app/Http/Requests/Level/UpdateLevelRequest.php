<?php

namespace App\Http\Requests\Level;

use App\Http\Requests\BaseRequest;

class UpdateLevelRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3",
            "min_levels" => "required|integer|min:1",
            // 'themes' => 'nullable|array|min:1',
            // 'themes.*' => 'exists:themes,id',
        ];
    }
}
