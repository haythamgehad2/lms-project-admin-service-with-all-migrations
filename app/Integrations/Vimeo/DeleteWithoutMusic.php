<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\DeleteAbstract;
use App\Models\VimeoVideo;

class DeleteWithoutMusic extends DeleteAbstract {
    protected function getFirstVimeo() : VimeoVideo | null {
        return $this->videoBank->firstVimeoWithoutMusic;
    }
}
