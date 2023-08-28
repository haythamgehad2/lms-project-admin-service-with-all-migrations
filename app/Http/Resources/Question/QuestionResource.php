<?php
namespace App\Http\Resources\Question;

use App\Http\Resources\BloomCategory\BloomCategoryResource;
use App\Http\Resources\LanuageMethod\LanguageMethodResource;
use App\Http\Resources\LanuageSkill\LanguageSkillResource;
use App\Http\Resources\LearningPath\LearningPathResource;
use App\Http\Resources\Level\LevelResource;
use App\Http\Resources\QuestionAnswer\QuestionAnswersResource;
use App\Http\Resources\QuestionDifficulty\QuestionDifficulyResource;
use App\Http\Resources\QuestionType\QuestionTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class QuestionResource extends JsonResource
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
            'question'=>$this->question,
            'question_type'=>new QuestionTypeResource($this->questionType),
            'sub_question_type'=>new QuestionTypeResource($this->subQuestionType),
            'level'=>new LevelResource($this->level),
            'learningPath'=>new LearningPathResource($this->learningPath),
            'language_method'=>new LanguageMethodResource($this->languageMethod),
            'language_skill'=>new LanguageSkillResource($this->languageSkill),
            'bloom_category'=>new BloomCategoryResource($this->bloomCategory),
            'question_difficulty'=>new QuestionDifficulyResource($this->questionDifficulty),
            'answers'=>QuestionAnswersResource::collection($this->answers),
            'question_pattern'=>$this->question_pattern,
            'hint'=>$this->hint,
            'question_audio'=>$this->question_audio ? env('APP_URL').'/audio/questions/'.$this->question_audio :null


        ];
    }
}
