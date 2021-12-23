<?php

namespace InfyOmLabs\LaravelEnvato\Managers;

use Carbon\Carbon;
use InfyOmLabs\LaravelEnvato\Auth\EnvatoCredentials;
use InfyOmLabs\LaravelEnvato\Events\EnvatoCredentialsRefreshed;

class AuthManager extends BaseManager
{
    /** @var EnvatoCredentials */
    public $authCredentials;

    /**
     * @return string
     */
    public function authRedirect()
    {
        $clientId = config('laravel-envato.oauth.client_id');
        $redirectUri = config('laravel-envato.oauth.redirect_uri');
        $apiEndPoint = config('laravel-envato.api_endpoint');
        $apiUri = $apiEndPoint.'/authorization?response_type=code&client_id=%s&redirect_uri=%s';

        return sprintf($apiUri, urlencode($clientId), urlencode($redirectUri));
    }

    public function handleRedirect($code)
    {
        $clientId = config('laravel-envato.oauth.client_id');
        $clientSecret = config('laravel-envato.oauth.client_secret');

        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ];

        $response = $this->envatoClient()->getClient()->request('POST', 'token', [
            'form_params' => $params
        ]);

        if ($response->getStatusCode() === 200) {
            $responseBody = json_decode((string) $response->getBody(), true);
            $authCredentials = new EnvatoCredentials();
            $authCredentials->accessToken = $responseBody['access_token'];
            $authCredentials->refreshToken = $responseBody['refresh_token'];
            $authCredentials->expiresIn = Carbon::now()->addSeconds($responseBody['expires_in']);
            return $authCredentials;
        }

        return null;
    }

    /**
     * @param  EnvatoCredentials  $authCredentials
     */
    public function loadAuthSession($authCredentials)
    {
        $this->authCredentials = $authCredentials;
        $this->refreshTokenIfExpired();
    }

    public function refreshTokenIfExpired()
    {
        if ($this->authCredentials->expiresIn->isPast()) {
            $this->refreshToken();
        }
    }

    public function refreshToken()
    {
        $clientId = config('laravel-envato.oauth.client_id');
        $clientSecret = config('laravel-envato.oauth.client_secret');

        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->authCredentials->refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ];

        $response = $this->envatoClient()->getClient()->request('POST', 'token', [
            'form_params' => $params
        ]);

        if ($response->getStatusCode() === 200) {
            $responseBody = json_decode((string) $response->getBody(), true);
            $this->authCredentials->accessToken = $responseBody['access_token'];
            $this->authCredentials->refreshToken = $responseBody['refresh_token'];
            $this->authCredentials->expiresIn = Carbon::now()->addSeconds($responseBody['expires_in']);
            EnvatoCredentialsRefreshed::dispatch($this->authCredentials);
            return $this->authCredentials;
        }

        return null;
    }
}
