<?php

namespace App\Http\Resources\Enrollment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentsResource extends JsonResource
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

            'role'=>[
                'id'=>$this->role->id,
                'name'=>$this->role->name,
            ],

            'class'=>[
                'id'=>$this->class->id,
                'name'=>$this->class->name,
            ],

            'term'=>[
                'id'=>$this->class->levelTerm->term->id,
                'name'=>$this->class->levelTerm->term->name,
            ],

            'level'=>[
                'id'=>$this->level->id,
                'name'=>$this->level->name,
            ],
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
