<?php

namespace App\Http\Requests\Term;

use App\Http\Requests\BaseRequest;

class CreateTermRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3",
            "levels" => "required|array|min:1",
            "levels.*" => "exists:levels,id",
            "school_id" => "nullable|exists:schools,id",

        ];
    }
}
