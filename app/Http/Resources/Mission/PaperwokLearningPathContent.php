<?php

namespace App\Http\Resources\Mission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaperwokLearningPathContent extends JsonResource
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
            'type'=>$this->type,
            'is_selected'=>$this->pivot->is_selected ? true :false,
            'order'=>$this->pivot->order,
            'url'=>$this->paper_work_full_url,
        ];
    }
}
