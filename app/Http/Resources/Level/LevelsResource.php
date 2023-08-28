<?php

namespace App\Http\Resources\Level;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelsResource extends JsonResource
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
           'created_at'=>$this->created_at,
           'updated_at'=>$this->updated_at
        ];
    }
}
