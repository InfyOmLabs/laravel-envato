<?php

namespace InfyOmLabs\LaravelEnvato\Client;

use Exception;
use GuzzleHttp\Client;
use InfyOmLabs\LaravelEnvato\Exceptions\EnvatoException;
use InfyOmLabs\LaravelEnvato\Exceptions\EnvatoRateLimitException;
use InfyOmLabs\LaravelEnvato\Managers\AuthManager;
use InfyOmLabs\LaravelEnvato\Utils\LaravelEnvatoUtils;
use Psr\Http\Message\ResponseInterface;

class EnvatoClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var AuthManager
     */
    private $authManager;

    public function initClient()
    {
        $this->authManager = app(AuthManager::class);
        $headers = [];
        if (!empty($this->authManager->authCredentials)) {
            $headers['Authorization'] = 'Bearer '.$this->authManager->authCredentials->accessToken;
        }

        $this->client = new Client([
            'headers'  => $headers,
            'base_uri' => $this->getEndpoint(),
        ]);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string|null
     */
    private function getEndpoint()
    {
        return config('laravel-envato.api_endpoint');
    }

    /**
     * @param string $url
     * @param array  $variables
     *
     * @throws \GuzzleHttp\Exception\GuzzleException|EnvatoRateLimitException
     *
     * @return EnvatoResponse
     */
    public function performGet($url, $variables = [])
    {
        $this->authManager->refreshTokenIfExpired();

        $options = [
            'query' => $variables,
        ];

        return $this->makeApiCall('GET', $url, $options);
    }

    /**
     * @param string $url
     * @param array  $variables
     *
     * @throws \GuzzleHttp\Exception\GuzzleException|EnvatoRateLimitException
     *
     * @return EnvatoResponse
     */
    public function performPost($url, $variables = [])
    {
        $this->authManager->refreshTokenIfExpired();

        $options = [
            'form_params' => $variables,
        ];

        return $this->makeApiCall('POST', $url, $options);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array  $options
     *
     * @throws EnvatoException
     * @throws EnvatoRateLimitException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return EnvatoResponse
     */
    private function makeApiCall($method, $url, $options)
    {
        try {
            $response = $this->client->request($method, $url, $options);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            LaravelEnvatoUtils::handleEnvatoException($e);
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return EnvatoResponse
     */
    private function parseResponse($response)
    {
        $envatoResponse = new EnvatoResponse();
        $envatoResponse->statusCode = $response->getStatusCode();
        $envatoResponse->headers = $response->getHeaders();
        $envatoResponse->body = json_decode($response->getBody(), true);
        $envatoResponse->retryAfter = $response->getHeader('Retry-After');

        return $envatoResponse;
    }
}
