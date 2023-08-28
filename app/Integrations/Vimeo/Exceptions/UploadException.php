<?php
namespace App\Integrations\Vimeo\Exceptions;

use Exception;

class UploadException extends Exception {
    public function __construct(string $msg = "") {
        parent::__construct($msg ?? "Can`t perform upload operation to Vimeo gateway");
    }
}
