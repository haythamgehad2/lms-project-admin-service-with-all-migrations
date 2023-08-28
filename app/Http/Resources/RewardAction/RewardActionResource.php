<?php

namespace App\Http\Resources\RewardAction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RewardActionResource extends JsonResource
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
            "action_name" => $this->action_name,
            "action_desc" => $this->action_desc,
            "max_trail" => $this->max_trail,
            "jeel_coins" => $this->jeel_coins,
            // "second_jeel_coins" => $this->second_jeel_coins,
            // "next_jeel_coins" => $this->next_jeel_coins,
            "jeel_xp" => $this->jeel_xp,
            // "second_jeel_xp" => $this->second_jeel_xp,
            // "next_jeel_xp" => $this->next_jeel_xp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
