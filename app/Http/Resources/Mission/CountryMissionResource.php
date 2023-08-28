<?php

namespace App\Http\Resources\Mission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryMissionResource extends JsonResource
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
            'name'=>$this->getTranslation('name',app()->getLocale()),
            'code'=>$this->code,
        ];
    }
}
