<?php

namespace InfyOmLabs\LaravelEnvato\Client;

class EnvatoResponse
{
    /** @var array */
    public $headers;

    /** @var mixed */
    public $body;

    /** @var int */
    public $retryAfter;

    /** @var int */
    public $statusCode;

    public function isOk()
    {
        return $this->statusCode === 200;
    }
}
