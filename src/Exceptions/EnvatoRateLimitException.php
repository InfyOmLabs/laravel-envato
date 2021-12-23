<?php

namespace InfyOmLabs\LaravelEnvato\Exceptions;

use Exception;
use Throwable;

class EnvatoRateLimitException extends Exception
{
    /**
     * @var int
     */
    public $retryAfter;

    /**
     * @param  int  $retryAfter
     * @param  string  $message
     * @param  int  $code
     * @param  Throwable|null  $previous
     */
    public function __construct($retryAfter, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->retryAfter = $retryAfter;
    }
}
