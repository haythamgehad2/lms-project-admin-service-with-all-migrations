<?php

namespace App\Http\Resources\JeelLevelXp;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JeelLevelXpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "level" => $this->level,
            "xp" => $this->xp,
            "updated_at"=> $this->updated_at,
            "created_at"=> $this->created_at,
        ];
    }
}
