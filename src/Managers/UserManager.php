<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

class UserManager extends BaseManager
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function getUsername()
    {
        return $this->envatoClient()->performGet('v1/market/private/user/username.json');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function getEmail()
    {
        return $this->envatoClient()->performGet('v1/market/private/user/email.json');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function accountDetails()
    {
        return $this->envatoClient()->performGet('v1/market/private/user/account.json');
    }
}
