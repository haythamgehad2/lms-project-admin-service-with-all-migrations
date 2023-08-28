<?php

namespace App\Http\Resources\Mission;

use App\Http\Resources\PeperWork\PeperWorksResoruce;
use App\Http\Resources\Quiz\QuizzesResource;
use App\Http\Resources\Video\VideosResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionPathContentResource extends JsonResource
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
         'videos' => VideosLearningPathContent::collection($this->videos),
         'papersWork' => PaperwokLearningPathContent::collection($this->papersWork),
         'quizzes' => QuizzesearningPathContent::collection($this->quizzes),
        ];
    }
}
