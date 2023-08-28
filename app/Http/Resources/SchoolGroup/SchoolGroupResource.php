<?php

namespace App\Http\Resources\SchoolGroup;

use App\Enums\SchoolGroupTypeEnum;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Level\LevelSchoolGoupResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'country'=>new CountryResource($this->country),
            'status'=>$this->status,
            'type'=>__('admin.school_types.types.'.$this->type),
            'levels'=>LevelSchoolGoupResource::collection($this->levels),
            'music_status'=>$this->music_status,
            'owner'=>new UserResource($this->owner),

        ];
    }
}
