<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

class SalesManager extends BaseManager
{
    /**
     * @param  int  $page
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function authorSales($page = 1)
    {
        $params = [
            'page' => $page
        ];

        return $this->envatoClient()->performGet('/v3/market/author/sales', $params);
    }

    /**
     * @param  array  $params
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function statement($params = [])
    {
        return $this->envatoClient()->performGet('/v3/market/user/statement', $params);
    }

    /**
     * @param string $username
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accountDetails($username)
    {
        return $this->envatoClient()->performGet("v1/market/user:$username.json");
    }

    /**
     * @param  string  $code
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function saleByCode($code)
    {
        return $this->envatoClient()->performGet("v3/market/author/sale", ['code' => $code]);
    }
}
