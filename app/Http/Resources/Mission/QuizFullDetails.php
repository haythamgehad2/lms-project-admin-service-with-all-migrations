<?php

namespace App\Http\Resources\Mission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizFullDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'total_question' => $this->total_question,
            'is_selected' => $this->pivot->is_selected ? true :false,
            'order' => $this->pivot->order,
            'type' => $this->type,
            'questions' => QuestionSimpleResource::collection($this->questions),
        ];
    }
}
