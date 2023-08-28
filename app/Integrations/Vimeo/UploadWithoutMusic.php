<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\UploadAbstract;

class UploadWithoutMusic extends UploadAbstract {
    protected function getVideoSizeInBytes() : int | null {
        return $this->videoBank->video_without_music_size_bytes;
    }

    protected function getVideoFullUrl() : string | null {
        return $this->videoBank->video_without_music_full_url;
    }
}
