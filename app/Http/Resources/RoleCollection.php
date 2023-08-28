<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use stdClass;

class RoleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data = [];
        foreach($this->collection as $item){
            $object = new stdClass();
            $object->id = $item->id;
            $object->name = $item->getTranslation('name', app()->getLocale());
            $object->code = $item->code;
            $object->users = $item->users;
            $object->permissions = $item->permissions;
            $data[] = $object;
        }

        return $data;
    }
}
