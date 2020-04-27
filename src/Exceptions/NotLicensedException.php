<?php
namespace Shahnewaz\CodeCanyonLicensor\Exceptions;

class NotLicensedException extends \Exception {
    public function __construct ($message = null, $code = 401) {
        $message = $message ?: 'Your copy of the software is not licensed.';
        throw new \Exception($message, $code);
    }
}