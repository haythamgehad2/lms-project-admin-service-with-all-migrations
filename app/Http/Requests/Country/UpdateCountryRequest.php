<?php

namespace App\Http\Requests\Country;

use App\Http\Requests\BaseRequest;

class UpdateCountryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|unique_translation:countries,name,{$this->id}|min:3|max:1000",
            "code" => "required|string|unique:countries,code,{$this->id}|min:2|max:10",
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
