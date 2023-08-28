<?php

namespace App\Http\Resources\Video;

use App\Http\Resources\LearningPath\LearningPathResource;
use App\Http\Resources\Level\LevelResource;
use App\Models\LearningPath;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'video_with_music_size_bytes' => $this->video_size_bytes,
            'video_with_music_fullback_url' => $this->video_full_url,
            'video_with_music_path' => $this->path,
            'video_with_music_disk' => $this->disk,
            'stream_path'=>$this->stream_path,
            'processed'=>$this->processed,
            'converted_for_streaming_at'=>$this->converted_for_streaming_at,
            // 'url'=>env('APP_URL').'/'.$this->disk.'/'.$this->path,
            'learningPath'=>new LearningPathResource($this->learningPath),
            'thumbnail'=>$this->thumbnail,
            'video_without_music_path' => $this->video_without_music_path,
            'video_without_music_disk' => $this->video_without_music_disk,
            'video_without_music_fallback_url' => $this->video_without_music_full_url,
            'video_without_music_size_bytes' => $this->video_without_music_size_bytes,
            'level'=>[
                'id' => $this->level?->id,
                'name' => $this->level?->name,
            ],

            'term'=>[
                'id' => $this->term?->id,
                'name' => $this->term?->name,
            ],
            // 'duration'=>$this->duration,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
