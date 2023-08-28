<?php
namespace App\Http\Resources\SchoolGroup;

use App\Enums\SchoolGroupTypeEnum;
use App\Http\Resources\Country\CountriesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolGroupsResource extends JsonResource
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
            'type'=>__('admin.school_types.types.'.$this->type),
            'music_status'=>$this->music_status,
            'country'=>new CountriesResource($this->country),
            'type'=>$this->type,
            'owner'=>$this->owner,
            'username'=>$this->username,
            'useremail'=>$this->useremail,
        ];
    }
}
