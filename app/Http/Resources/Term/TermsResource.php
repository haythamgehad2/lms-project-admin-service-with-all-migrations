<?php

namespace App\Http\Resources\Term;

use App\Http\Resources\Level\LevelsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            // 'levels'=>LevelsResource::collection($this->levels),
        ];
    }
}
