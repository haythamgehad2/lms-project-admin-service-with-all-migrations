<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use stdClass;

class SchoolCollection extends ResourceCollection
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
            $object->school_group = $item->schoolGroup->name;
            $object->status = $item->status;
            $object->music_status = $item->music_status;
            $object->owner = $item->owner;
            $object->subscription_start_date = $item->SubscriptionStartDate;
            $object->subscription_end_date = $item->subscription_end_date;
            $object->username = $item->username;
            $object->useremail = $item->useremail;
            $object->logo = $item->logo;
            $data[] = $object;
        }

        return $data;
    }
}
