<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use stdClass;

class PermissionCollection extends ResourceCollection
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
            // $object->name = $item->getTranslation('name', app()->getLocale());
            $object->name = $item->name;
            $object->code = $item->code;
            $data[] = $object;
        }

        return $data;
    }
}
