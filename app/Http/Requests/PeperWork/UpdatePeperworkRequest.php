<?php

namespace App\Http\Requests\PeperWork;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePeperworkRequest extends BaseRequest
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
            "name" => "required|string|min:3|max:1000",
            "description" => "required|string|min:5|max:1000",
            'learning_path_id'=> 'required|integer|exists:learning_paths,id',
            'level_id'=> 'required|integer|exists:levels,id',
            'term_id'=> ['required',Rule::exists('level_terms','term_id')->where('level_id',request()->level_id)],
            "type" => "required|in:participatory,single",
            "file" => "nullable|mimetypes:application/pdf|max:10000",
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'paper_work_without_color' => "nullable|mimetypes:application/pdf|max:10000",
            'paper_work_final_degree'=>"required|integer"
        ];
    }
}
