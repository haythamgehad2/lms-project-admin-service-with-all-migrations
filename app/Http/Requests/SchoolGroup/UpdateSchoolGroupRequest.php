<?php

namespace App\Http\Requests\SchoolGroup;

use App\Http\Requests\BaseRequest;

class UpdateSchoolGroupRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3",
            "country_id" => "required|exists:countries,id",
            "status" => "integer|in:1,0",
            "type" => "required|string|in:international,national",
            "music_status" => "integer|in:1,0",
            "owner_id" => "required|exists:users,id",
        ];
    }
}
