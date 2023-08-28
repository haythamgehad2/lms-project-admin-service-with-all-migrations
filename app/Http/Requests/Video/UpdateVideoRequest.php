<?php

namespace App\Http\Requests\Video;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\BaseFormatter;

class UpdateVideoRequest extends BaseRequest
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
            'title' => 'required|string|max:1000|min:3',
            'description' => 'nullable|string|max:1000|min:3',
            'learning_path_id' => 'required|integer|exists:learning_paths,id',
            'level_id'=> 'required|integer|exists:levels,id',
            'term_id'=> ['required',Rule::exists('level_terms','term_id')->where('level_id',request()->level_id)],
            'original_name' => 'required|string|max:1000|min:3',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
            'video_without_music' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
        ];
    }
}
