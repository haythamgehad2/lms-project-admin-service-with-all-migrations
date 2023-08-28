<?php
namespace App\Http\Requests\Level;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AttachLevelsSchoolRequest extends BaseRequest
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

            'levels' => 'required|array|min:1',
            'school_id' => ['required',Rule::exists('schools','id')],
            'levels.*' => ['required',Rule::exists('levels','id')->where('school_id',null)],

        ];
    }
}
