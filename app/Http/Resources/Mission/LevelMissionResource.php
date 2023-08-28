<?php

namespace App\Http\Resources\Mission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelMissionResource extends JsonResource
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
        ];
    }
}
