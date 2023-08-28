<?php

namespace App\Http\Resources\Mission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionFullDetailsResource extends JsonResource
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
            'data_range' => $this->data_range,
            'mission_image' => $this->mission_image,
            'level' => new LevelMissionResource($this->level),
            'term' => new TermMissionResource($this->term),
            'country' => new CountryMissionResource($this->country),
            'learning_paths' => LearningPathFullDetails::collection(
                $this->learningPaths?->load([
                    "videos" => fn($q) => $q->where("mission_id", $this->id),
                    "quizzes" => fn($q) => $q->where("mission_id", $this->id),
                    "papersWork" => fn($q) => $q->where("mission_id", $this->id),
                ])
            ),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
