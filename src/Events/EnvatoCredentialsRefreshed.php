<?php

namespace InfyOmLabs\LaravelEnvato\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use InfyOmLabs\LaravelEnvato\Auth\EnvatoCredentials;

class EnvatoCredentialsRefreshed
{
    use Dispatchable, SerializesModels;

    /** @var EnvatoCredentials */
    public $credentials;

    /**
     * @param EnvatoCredentials $credentials
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }
}
