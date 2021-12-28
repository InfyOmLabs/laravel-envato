<?php

namespace InfyOmLabs\LaravelEnvato\Utils;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;
use InfyOmLabs\LaravelEnvato\Exceptions\EnvatoException;
use InfyOmLabs\LaravelEnvato\Exceptions\EnvatoRateLimitException;

class LaravelEnvatoUtils
{
    /**
     * @param Exception $e
     *
     * @throws EnvatoException
     * @throws EnvatoRateLimitException
     */
    public static function handleEnvatoException($e)
    {
        /** @var ClientException $e */
        if ($e->getCode() === Response::HTTP_TOO_MANY_REQUESTS) {
            throw new EnvatoRateLimitException(intval($e->getResponse()->getHeader('Retry-After')[0]));
        }

        $response = json_decode($e->getResponse()->getBody()->getContents(), true);

        if (isset($response['error']) and isset($response['error_description'])) {
            throw new EnvatoException($response['error'], $response['error_description'], $e->getCode(), $e);
        }

        throw $e;
    }
}
