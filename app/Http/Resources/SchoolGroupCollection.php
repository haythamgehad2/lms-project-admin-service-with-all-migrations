<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use stdClass;

class SchoolGroupCollection extends ResourceCollection
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
            $object->name = $item->name;
            $object->country = $item->country;
            $object->status = $item->status;
            $object->music_status = $item->music_status;
            $object->owner = $item->owner;
            $object->username = $item->username;
            $object->useremail = $item->useremail;
            $data[] = $object;
        }

        return $data;
    }
}
