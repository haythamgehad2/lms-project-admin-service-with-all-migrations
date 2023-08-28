<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ListRoleRequest extends BaseRequest
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
            'page'=>'nullable|integer',
            'per_page'=>'nullable|integer',
            'name'=>'nullable|string',
            'order'=>'nullable|string|in:DESC,ASC',
            'system_role'=>'nullable|in:1,0',
            'system_enrollment'=>'nullable|in:1',
            'list_all'=>'nullable|in:true'

        ];
    }
}
