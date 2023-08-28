<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\Permission\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            "code"=>$this->code,
            "description"=>$this->description,
            "is_default"=>$this->is_default,
            "permissions"=>PermissionResource::collection($this->permissions),
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
