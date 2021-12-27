<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

class ItemsManager extends BaseManager
{
    /**
     * @param array $params
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function searchItems($params)
    {
        return $this->envatoClient()->performGet('/v1/discovery/search/search/item', $params);
    }

    /**
     * @param string $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function getItem($id)
    {
        return $this->envatoClient()->performGet('/v3/market/catalog/item', ['id' => $id]);
    }

    /**
     * @param string $username
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InfyOmLabs\LaravelEnvato\Exceptions\EnvatoRateLimitException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function userItemsBySite($username)
    {
        return $this->envatoClient()->performGet("v1/market/user-items-by-site:$username.json");
    }
}
