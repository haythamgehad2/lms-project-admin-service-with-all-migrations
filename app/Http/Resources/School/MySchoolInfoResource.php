<?php

namespace App\Http\Resources\School;

use App\Http\Resources\Package\PackageResoruce;
use App\Http\Resources\SchoolGroup\SchoolGroupResource;
use App\Http\Resources\SchoolType\SchoolTypeResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MySchoolInfoResource extends JsonResource
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
            'status'=>$this->status,
            'music_status'=>$this->music_status,
            'admin'=>new UserResource($this->admin),
            'school_type'=>new SchoolTypeResource($this->schoolType),
            'school_group'=>new SchoolGroupResource($this->schoolGroup),
            'package'=>new PackageResoruce($this->package),
            'subscription_start_date'=>$this->subscription_start_date,
            'subscription_end_date'=>$this->subscription_end_date,
            'logo'=>$this->logo,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
