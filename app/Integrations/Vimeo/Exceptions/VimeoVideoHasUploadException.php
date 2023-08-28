<?php
namespace App\Integrations\Vimeo\Exceptions;

use Exception;

class VimeoVideoHasUploadException extends Exception {
    public function __construct() {
        parent::__construct("Can`t perform replace operation to Vimeo gateway, video has an upload error");
    }
}
