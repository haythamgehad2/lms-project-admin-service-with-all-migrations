<?php

namespace App\Http\Resources\Mission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionLearningPathsResource extends JsonResource
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
            'mission_id'=>$this->pivot->mission_id,
            'name'=>$this->name,
            'description'=>$this->description,
            'order'=>$this->pivot->order,
            'is_selected'=>$this->pivot->is_selected ? true :false,

        ];
    }
}
