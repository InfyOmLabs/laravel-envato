<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

class SalesManager extends BaseManager
{
    /**
     * @param int $page
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function authorSales($page = 1)
    {
        $params = [
            'page' => $page,
        ];

        return $this->envatoClient()->performGet('/v3/market/author/sales', $params);
    }

    /**
     * @param string $code
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function authorSaleByCode($code)
    {
        $params = [
            'code' => $code,
        ];

        return $this->envatoClient()->performGet('/v3/market/author/sale', $params);
    }

    /**
     * @param array $params
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function statement($params = [])
    {
        return $this->envatoClient()->performGet('/v3/market/user/statement', $params);
    }

    /**
     * @param string $username
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function accountDetails($username)
    {
        return $this->envatoClient()->performGet("v1/market/user:$username.json");
    }

    /**
     * @param string $code
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function saleByCode($code)
    {
        return $this->envatoClient()->performGet('v3/market/author/sale', ['code' => $code]);
    }
}
