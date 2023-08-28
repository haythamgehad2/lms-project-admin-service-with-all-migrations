<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\ReplaceAbstract;
use App\Models\VimeoVideo;

class Replace extends ReplaceAbstract {
    protected function getFirstVimeo() : VimeoVideo | null {
        return $this->videoBank->firstVimeo;
    }

    protected function getVideoSizeInBytes() : int | null {
        return $this->videoBank->video_size_bytes;
    }

    protected function getVideoFullUrl() : string | null {
        return $this->videoBank->video_full_url;
    }
}
