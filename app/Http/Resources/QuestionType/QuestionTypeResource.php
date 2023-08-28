<?php

namespace App\Http\Resources\QuestionType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionTypeResource extends JsonResource
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
            'slug'=>$this->slug,
            'parent'=>$this->when(isset($this->parent), new QuestionTypeResource($this->parent)),
            'children'=>QuestionTypesResource::collection($this->children),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
