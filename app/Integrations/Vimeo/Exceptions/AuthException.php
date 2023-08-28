<?php
namespace App\Integrations\Vimeo\Exceptions;

use Exception;

class AuthException extends Exception {
    public function __construct(string $msg = "") {
        parent::__construct($msg ?? "Can`t perform auth operation to Vimeo gateway");
    }
}
