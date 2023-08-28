<?php

namespace App\Http\Resources\QuizQuestionDiffuclty;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionDifficultyQuizResoruce extends JsonResource
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
           'questions_count'=>$this->questions_count

        ];
    }
}
