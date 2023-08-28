<?php

namespace App\Http\Resources\Mission;

use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\LearningPath\LearningPathsResource;
use App\Http\Resources\Level\LevelResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionsResource extends JsonResource
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
            'data_range'=>$this->data_range,
            'level' => new LevelMissionResource($this->level),
            'term' => new TermMissionResource($this->term),
            'country' => new CountryMissionResource($this->country),
            'learningpaths' => LearningPathsResource::collection($this->learningPaths),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
