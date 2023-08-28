<?php

namespace App\Http\Resources\SchoolGroup;

use App\Http\Resources\Mission\MissionFullDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelFullDetailsResource extends JsonResource
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
            'terms' => TermSimpleResource::collection($this->terms),
            'missions' => MissionFullDetailsResource::collection($this->missions),
        ];
    }
}
