<?php
namespace App\Http\Requests\User;
use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
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
            'status'=>'nullable|in:active,block,deactivated,unverified',
            'page'=>'nullable|integer',
            'per_page'=>'nullable|integer',
            'name'=>'nullable|string',
            'order'=>'nullable',
            'list_all'=>'nullable|in:true'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function messages()
    {
        return [
        'status.in' => 'The :attribute field is required in active,block,deactivated,unverified.'
        ];
    }
}
