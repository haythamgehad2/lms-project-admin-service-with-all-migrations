<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\ReplaceAbstract;
use App\Models\VimeoVideo;

class ReplaceWithoutMusic extends ReplaceAbstract {
    protected function getFirstVimeo() : VimeoVideo | null {
        return $this->videoBank->firstVimeoWithoutMusic;
    }

    protected function getVideoSizeInBytes() : int | null {
        return $this->videoBank->video_without_music_size_bytes;
    }

    protected function getVideoFullUrl() : string | null {
        return $this->videoBank->video_without_music_full_url;
    }
}
