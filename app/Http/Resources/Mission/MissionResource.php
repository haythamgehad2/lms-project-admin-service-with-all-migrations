<?php

namespace App\Http\Resources\Mission;

use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\LearningPath\LearningPathsResource;
use App\Http\Resources\Level\LevelResource;
use App\Http\Resources\PeperWork\PeperWorksResoruce;
use App\Http\Resources\Term\TermResource;
use App\Http\Resources\Video\VideosResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionResource extends JsonResource
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
            'mission_image' => $this->mission_image,
            'level' => new LevelMissionResource($this->level),
            'term' => new TermMissionResource($this->term),
            'country' => new CountryMissionResource($this->country),
            'learningpaths' => MissionPathContentResource::collection(
                $this->learningPaths()
                        ->with(['videos' => function ($query){
                        $query->where('mission_id',$this->id);
                    }])
                        ->with(['quizzes' => function ($query){
                        $query->where('mission_id',$this->id);
                    }])
                    ->with(['papersWork'=> function ($query){
                        $query->where('mission_id',$this->id);
                    }])->get()),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at

        ];
    }
}
