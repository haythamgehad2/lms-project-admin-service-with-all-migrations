<?php

namespace App\Http\Resources\SchoolGroup;

use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Mission\MissionsResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolGroupFullDetailsResource extends JsonResource
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
            'country' => new CountryResource($this->country),
            'status' => $this->status,
            'type' => $this->type,
            'levels' => LevelFullDetailsResource::collection($this->levels),
            'music_status' => $this->music_status,
            // 'missions'=>MissionsResource::collection($this->missionsSchoolGroup),
            'owner' => new UserResource($this->owner),
        ];
    }
}
