<?php

namespace App\Http\Requests\Class;

use App\Http\Requests\BaseRequest;

class CreateClassRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3",
            // "level_id" => "required|exists:levels,id",
            // "term_id" => "required|exists:terms,id",
            "school_id" => "nullable|exists:schools,id",
            "level_term_id" => "required|exists:level_terms,id",

        ];
    }
}
