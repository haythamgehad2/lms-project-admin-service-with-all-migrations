<?php

namespace App\Http\Resources\QuestionAnswer;

use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionAnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return[
            'id'=>$this->id,
            'answer'=>$this->question->question_pattern == 'image' ? $this->question_answer_image :$this->answer,
            'correct'=>$this->correct,
            'audio'=>$this->answer_audio ? env('APP_URL').'/audio/answer/'.$this->answer_audio :null,
            'created_at'=>$this->created_at,
            'match_from'=>$this->when($this->question->questionType->slug == 'match',$this->match_from),
            'match_to'=>$this->when($this->question->questionType->slug == 'match',$this->match_to),
            'order'=>$this->when($this->order != null , $this->order),
            'correct'=>$this->when($this->correct != null , $this->correct),
            'correct_answers'=>$this->when($this->correct_answers != null,json_decode($this->correct_answers)),

        ];
    }
}
