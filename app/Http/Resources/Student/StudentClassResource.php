<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentClassResource extends JsonResource
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
            
            'school'=>[
                'id'=>$this->school->id,
                'name'=>$this->school->name,
            ],

            'user'=>[
                'id'=>$this->user->id,
                'name'=>$this->user->name,
                'email'=>$this->user->email,
            ],

            'class'=>[
                'id'=>$this->class->id,
                'name'=>$this->class->name,
            ],

            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
