<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizQuestionResource extends JsonResource
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
            'name'=>$this->question,
            'question_type'=>[
                'id'=>$this->questionType->id,
                'name'=>$this->questionType->name,

            ],
            'is_selected'=>$this->pivot->is_selected ? true :false,
            'order'=>$this->pivot->order,
            'quiz_id'=>$this->pivot->quiz_id,

        ];
    }
}
