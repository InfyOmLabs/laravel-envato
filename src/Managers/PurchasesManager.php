<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

class PurchasesManager extends BaseManager
{
    /**
     * @param int $page
     * @param string $filterBy
     * @param false $includeAllItemDetails
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InfyOmLabs\LaravelEnvato\Exceptions\EnvatoRateLimitException
     */
    public function listAllPurchases($page = 1, $filterBy = '', $includeAllItemDetails = false)
    {
        $params = [
            'page' => $page,
            'filter_by' => $filterBy,
            'include_all_item_details' => $includeAllItemDetails,
        ];

        return $this->envatoClient()->performGet('/v3/market/buyer/list-purchases', $params);
    }

    /**
     * @param int $page
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \InfyOmLabs\LaravelEnvato\Client\EnvatoResponse
     */
    public function listAppCreatorPurchases($page = 1)
    {
        $params = [
            'page' => $page,
        ];

        return $this->envatoClient()->performGet('/v3/market/buyer/purchases', $params);
    }
}
