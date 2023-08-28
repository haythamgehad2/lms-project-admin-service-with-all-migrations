<?php

namespace App\Http\Resources\PeperWork;

use App\Http\Resources\LearningPath\LearningPathResource;
use App\Http\Resources\Level\LevelResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeperWorksResoruce extends JsonResource
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
            'description'=>$this->description,
            'level'=>new LevelResource($this->level),
            'term'=>[
                'id' => $this->term?->id,
                'name' => $this->term?->name,
            ],
            'learningPath'=>new LearningPathResource($this->learningPath),
            'type'=>__('admin.paper_works.types.'.$this->type->value),
            'paper_work_final_degree' => $this->paper_work_final_degree,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
