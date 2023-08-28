<?php

namespace App\Http\Resources\Question;

use App\Http\Resources\BloomCategory\BloomCategoryResource;
use App\Http\Resources\LanuageSkill\LanguageSkillResource;
use App\Http\Resources\LearningPath\LearningPathResource;
use App\Http\Resources\Level\LevelResource;
use App\Http\Resources\QuestionDifficulty\QuestionDifficulyResource;
use App\Http\Resources\QuestionType\QuestionTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
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
            'question_pattern'=>$this->question_pattern,
            'question'=>$this->question,
            'question_type'=>new QuestionTypeResource($this->questionType),
            'sub_question_type'=>new QuestionTypeResource($this->subQuestionType),
            'question_difficulty'=>new QuestionDifficulyResource($this->questionDifficulty),
            'language_skill'=>new LanguageSkillResource($this->languageSkill),
            'bloom_category'=>new BloomCategoryResource($this->bloomCategory),
            'learningPath'=>new LearningPathResource($this->learningPath),
            'level'=>new LevelResource($this->level),
            'hint'=>$this->hint,

        ];
    }
}
