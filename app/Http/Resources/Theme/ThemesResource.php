<?php

namespace App\Http\Resources\Theme;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThemesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "description"=>$this->description,
            "theme_image"=>$this->theme_image,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
