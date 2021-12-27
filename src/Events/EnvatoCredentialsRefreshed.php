<?php

namespace InfyOmLabs\LaravelEnvato\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use InfyOmLabs\LaravelEnvato\Auth\EnvatoCredentials;

class EnvatoCredentialsRefreshed
{
    use Dispatchable;
    use SerializesModels;

    /** @var EnvatoCredentials */
    public $credentials;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }
}
