<?php

namespace App\Http\Resources\Mission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideosLearningPathContent extends JsonResource
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
            "title"=>$this->title,
            "description"=>$this->description,
            "original_name"=>$this->original_name,
            'disk'=>$this->disk,
            'path'=>$this->path,
            'stream_path'=>$this->stream_path,
            'processed'=>$this->processed,
            'is_selected'=>$this->pivot->is_selected ? true :false,
            'order'=>$this->pivot->order,
            'thumbnail'=>$this->thumbnail,
            'converted_for_streaming_at'=>$this->converted_for_streaming_at,
            'url'=>$this->video_full_url,
        ];
    }
}
