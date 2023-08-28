<?php

namespace App\Http\Requests\JeelGemPrice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJeelGemPriceRequest extends FormRequest
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
            "jeel_coins_quantity" => "required|integer|min:1"
        ];
    }
}
