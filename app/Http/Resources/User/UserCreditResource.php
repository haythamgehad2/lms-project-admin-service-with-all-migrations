<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCreditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "jeel_coins" => $this->jeel_coins,
            "jeel_gems" => $this->jeel_gems,
            "jeel_xp" => $this->jeel_xp,
            "level" => $this->level,
            "level_percentage" => $this->level_percentage,

        ];
    }
}
