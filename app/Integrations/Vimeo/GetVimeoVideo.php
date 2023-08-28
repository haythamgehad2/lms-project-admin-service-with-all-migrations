<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\GetAbstract;
use App\Models\VimeoVideo;

class GetVimeoVideo extends GetAbstract {
    protected function getFirstVimeo() : VimeoVideo | null {
        return $this->videoBank->firstVimeo;
    }
}
