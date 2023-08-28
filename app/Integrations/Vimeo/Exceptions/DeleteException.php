<?php
namespace App\Integrations\Vimeo\Exceptions;

use Exception;

class DeleteException extends Exception {
    public function __construct(string $msg = "") {
        parent::__construct($msg ?? "Can`t perform delete operation to Vimeo gateway");
    }
}
