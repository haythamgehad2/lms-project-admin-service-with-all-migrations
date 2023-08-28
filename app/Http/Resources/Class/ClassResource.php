<?php

namespace App\Http\Resources\Class;

use App\Http\Resources\Level\LevelResource;
use App\Http\Resources\Level\LevelsResource;
use App\Http\Resources\Term\TermsResource;
use App\Http\Resources\TermResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
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
            'term'=> new TermsResource($this->levelTerm->term),
            'level'=>new LevelsResource($this->levelTerm->level),
            'level_term_id'=>$this->level_term_id,
            'level_term_id'=>$this->level?->name.'-'.$this->term?->name,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
