<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

class UserManager extends BaseManager
{
    /**
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUsername()
    {
        return $this->envatoClient()->performGet('v1/market/private/user/username.json');
    }
}
