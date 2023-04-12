<?php

namespace InfyOmLabs\LaravelEnvato\Utils;

use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
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
    public static function handleEnvatoException($e, $errorData = [])
    {
        /** @var ClientException $e */
        if ($e->getCode() === Response::HTTP_TOO_MANY_REQUESTS) {
            throw new EnvatoRateLimitException(intval($e->getResponse()->getHeader('Retry-After')[0]));
        }

        if ($e instanceof RequestException) {
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true);

                if (!isset($response['error'])) {
                    throw $e;
                }

                $error = $response['error'];
                $message = $e->getMessage();

                if (isset($response['error_description'])) {
                    $message = $response['error_description'];
                }

                throw new EnvatoException($error, $message, $e->getCode(), $e, $errorData);
            }
        }

        throw $e;
    }
}
