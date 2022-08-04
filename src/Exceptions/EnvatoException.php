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
     * @var array
     */
    public $errorData;

    /**
     * @param string         $error
     * @param string         $message
     * @param int            $code
     * @param array          $errorData
     * @param Throwable|null $previous
     */
    public function __construct($error, $message = '', $code = 0, Throwable $previous = null, $errorData = [])
    {
        parent::__construct($message, $code, $previous);
        $this->error = $error;
        $this->errorData = $errorData;
    }
}
