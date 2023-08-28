<?php

namespace App\Http\Resources\Class;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassMissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'order'=>$this->order,
            'is_selected'=>isset($this->is_selected) ? $this->is_selected : null,
            'start_date'=>$this->start_date ? Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('Y-m-d') : null,
            'end_date'=> $this->end_date ? Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)->format('Y-m-d') : null,
        ];
    }
}
