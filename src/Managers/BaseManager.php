<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

use InfyOmLabs\LaravelEnvato\Client\EnvatoClient;

class BaseManager
{
    /** @var EnvatoClient */
    private $client;

    public function envatoClient()
    {
        if (empty($this->client)) {
            $client = app(EnvatoClient::class);
            $this->client = $client;
            $this->client->initClient();
        }

        return $this->client;
    }
}
