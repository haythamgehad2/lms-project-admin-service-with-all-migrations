<?php

namespace App\Http\Resources\Video;

use App\Http\Resources\LearningPath\LearningPathResource;
use App\Http\Resources\Level\LevelResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "description"=>$this->description,
            "original_name"=>$this->original_name,
            'learningPath'=>new LearningPathResource($this->learningPath),
            'level'=>[
                'id' => $this->level?->id,
                'name' => $this->level?->name,
            ],
            'term'=>[
                'id' => $this->term?->id,
                'name' => $this->term?->name,
            ],
            'thumbnail'=>$this->thumbnail,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
