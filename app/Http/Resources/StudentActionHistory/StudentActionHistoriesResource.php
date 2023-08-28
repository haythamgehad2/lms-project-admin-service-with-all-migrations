<?php

namespace App\Http\Resources\StudentActionHistory;

use App\Http\Resources\RewardAction\RewardActionResource;
use App\Http\Resources\User\UserSimpleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentActionHistoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "student" => new UserSimpleResource($this->whenLoaded("student")),
            "reward_action" => new RewardActionResource($this->whenLoaded("rewardAction")),
            "jeel_coins" => $this->jeel_coins,
            "jeel_xp" => $this->jeel_xp,
            "updated_at"=> $this->updated_at,
            "created_at"=> $this->created_at,
        ];
    }
}
