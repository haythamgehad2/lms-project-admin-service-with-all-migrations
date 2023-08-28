<?php

namespace App\Http\Resources\StudentActionHistory;

use App\Http\Resources\RewardAction\RewardActionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentActionHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "student_id" => $this->student_id,
            "reward_action" => new RewardActionResource($this->whenLoaded("rewardAction")),
            "jeel_coins" => $this->jeel_coins,
            "jeel_xp" => $this->jeel_xp,
            "updated_at"=> $this->updated_at,
            "created_at"=> $this->created_at,
        ];
    }
}
