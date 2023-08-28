<?php

namespace App\Http\Resources\PeperWork;

use App\Http\Resources\LearningPath\LearningPathResource;
use App\Http\Resources\Level\LevelResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeperWorkResoruce extends JsonResource
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
            'disk'=>$this->disk,
            'path'=>$this->path,
            'paper_work_full_url' => $this->paper_work_full_url,
            'paper_work_size_bytes' => $this->paper_work_size_bytes,
            'paper_work_without_color_disk' => $this->paper_work_without_color_disk,
            'paper_work_without_color_path' => $this->paper_work_without_color_path,
            'paper_work_without_color_full_url' => $this->paper_work_without_color_full_url,
            // 'paper_work_without_color_size_bytes' => $this->paper_work_without_color_size_bytes,
            'type'=>__('admin.paper_works.types.'.$this->type->value),
            'thumbnail'=>$this->thumbnail,
            'paper_work_final_degree' => $this->paper_work_final_degree,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
