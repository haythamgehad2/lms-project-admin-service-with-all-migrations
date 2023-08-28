<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\DeleteAbstract;
use App\Models\VimeoVideo;

class Delete extends DeleteAbstract {
    protected function getFirstVimeo() : VimeoVideo | null {
        return $this->videoBank->firstVimeo;
    }
}
