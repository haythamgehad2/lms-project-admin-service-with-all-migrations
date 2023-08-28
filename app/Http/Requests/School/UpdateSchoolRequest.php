<?php

namespace App\Http\Requests\School;

use App\Http\Requests\BaseRequest;

class UpdateSchoolRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|min:3",
            "school_group_id" => "required|exists:school_groups,id",
            "school_type_id" => "required|exists:school_types,id",
            "status" => "integer",
            "music_status" => "integer",
            "admin_id" => "required|exists:users,id",
            // "username" => "required|string|min:3",
            // "useremail" => "required|email",
            "subscription_start_date" => "required",
            "subscription_end_date" => "required",
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'package_id' => "required|exists:packages,id",
        ];
    }
}
