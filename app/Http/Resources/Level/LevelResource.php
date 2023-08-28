<?php

namespace App\Http\Resources\Level;

use App\Http\Resources\SchoolGroup\SchoolGroupResource;
use App\Http\Resources\Theme\ThemeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
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
            'min_levels' => $this->min_levels,
            'themes' => ThemeResource::collection($this->themes),
            'school_groups' => LevelSchoolGoupResource::collection($this->school_groups),
             'missions' => $this->when(auth()->user()->tokenCan('rearrange-missions') || auth()->user()->tokenCan('manage-content') && isset($this->school_id), LevelMissionResource::collection($this->missions)),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
