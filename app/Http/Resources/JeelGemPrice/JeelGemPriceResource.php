<?php

namespace App\Http\Resources\JeelGemPrice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JeelGemPriceResource extends JsonResource
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
            "quantity" => $this->quantity,
            "jeel_coins_quantity" => $this->jeel_coins_quantity,
            "updated_at"=> $this->updated_at,
            "created_at"=> $this->created_at,
        ];
    }
}
