<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSimpleResource extends JsonResource
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
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "name" => $this->name,
            "email" => $this->email,
            "is_super_admin" => $this->is_super_admin,
            "last_attempt"  => $this->last_attempt,
            "verification_sent_at" => $this->verification_sent_at,
            "mobile" => $this->mobile,
            "social_media" => $this->social_media,
            "avatar" => $this->avatar,
            "user_credit" => new UserCreditResource($this->whenLoaded("userCredit")),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
