<?php

namespace InfyOmLabs\LaravelEnvato\Exceptions;

use Exception;
use Throwable;

class EnvatoException extends Exception
{
    /**
     * @var string
     */
    public $error;

    /**
     * @param  string  $error
     * @param  string  $message
     * @param  int  $code
     * @param  Throwable|null  $previous
     */
    public function __construct($error, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->error = $error;
    }
}
