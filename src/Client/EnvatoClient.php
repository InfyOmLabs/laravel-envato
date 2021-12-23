<?php

namespace InfyOmLabs\LaravelEnvato\Client;

use InfyOmLabs\LaravelEnvato\Exceptions\EnvatoRateLimitException;
use Exception;
use GuzzleHttp\Client;
use InfyOmLabs\LaravelEnvato\Managers\AuthManager;
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
            'headers' => $headers,
            'base_uri' => $this->getEndpoint()
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
     * @param  string  $url
     * @param  array  $variables
     *
     * @return EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException|EnvatoRateLimitException
     */
    public function performGet($url, $variables = [])
    {
        $this->authManager->refreshTokenIfExpired();

        $response = [];
        try {
            $response = $this->client->request('GET', $url, [
                'query' => $variables
            ]);
        } catch (Exception $e) {
            if ($e->getCode() == 429) {
                throw new EnvatoRateLimitException(intval($e->getResponse()->getHeader('Retry-After')[0]));
            }
        }

        return $this->parseResponse($response);
    }

    /**
     * @param  string  $url
     * @param  array  $variables
     *
     * @return EnvatoResponse
     * @throws \GuzzleHttp\Exception\GuzzleException|EnvatoRateLimitException
     */
    public function performPost($url, $variables = [])
    {
        $this->authManager->refreshTokenIfExpired();

        $response = [];
        try {
            $response = $this->client->request('POST', $url, [
                'form_params' => $variables
            ]);
        } catch (Exception $e) {
            if ($e->getCode() == 429) {
                throw new EnvatoRateLimitException(intval($e->getResponse()->getHeader('Retry-After')[0]));
            }
        }

        return $this->parseResponse($response);
    }

    /**
     * @param  ResponseInterface  $response
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
