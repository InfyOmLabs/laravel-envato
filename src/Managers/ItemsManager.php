<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

class ItemsManager extends BaseManager
{
    /**
     * @param array $params
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchItems($params)
    {
        return $this->envatoClient()->performGet('/v1/discovery/search/search/item', $params);
    }

    /**
     * @param string $id
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getItem($id)
    {
        return $this->envatoClient()->performGet('/v3/market/catalog/item', ['id' => $id]);
    }

    /**
     * @param  string  $username
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InfyOmLabs\LaravelEnvato\Exceptions\EnvatoRateLimitException
     */
    public function userItemsBySite($username)
    {
        return $this->envatoClient()->performGet("v1/market/user-items-by-site:$username.json");
    }
}
