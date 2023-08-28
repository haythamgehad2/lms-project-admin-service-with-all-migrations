<?php

namespace App\Http\Resources\Quiz;

use App\Enums\QuizTypesEnum;
use App\Http\Resources\LearningPath\LearningPathResource;
use App\Http\Resources\Level\LevelResource;
use App\Http\Resources\Question\QuestionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            'type' => $this->type,
            'learning_path' => new LearningPathResource($this->learningPath),
            'questions_difficulties' => QuestionDifficultyResource::collection($this->questionsDifficulties),
            'level' => New LevelResource($this->level),
            'term'=>[
                'id' => $this->term?->id,
                'name' => $this->term?->name,
            ],
            'questions' =>  QuizQuestionResource::collection($this->questions),
            'total_grade' => $this->total_grade,
            'success_grade' => $this->success_grade,
            'calc_type' => $this->calc_type,
            'total_grade_points' => $this->total_grade_points,
            'easy_grade_point' => $this->easy_grade_point,
            'medium_grade_point' => $this->medium_grade_point,
            'hard_grade_point' => $this->hard_grade_point,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
