<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\UploadAbstract;

class Upload extends UploadAbstract {
    protected function getVideoSizeInBytes() : int | null {
        return $this->videoBank->video_size_bytes;
    }

    protected function getVideoFullUrl() : string | null {
        return $this->videoBank->video_full_url;
    }
}
