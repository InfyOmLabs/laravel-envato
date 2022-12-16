<?php

namespace InfyOmLabs\LaravelEnvato\Auth;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class EnvatoCredentials implements Arrayable
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $accessToken;

    /**
     * @var string
     */
    public $refreshToken;

    /**
     * @var Carbon
     */
    public $expiresIn;

    /**
     * @param array $input
     */
    public function __construct($input = [])
    {
        if (isset($input['id'])) {
            $this->id = $input['id'];
        }

        if (isset($input['access_token'])) {
            $this->accessToken = $input['access_token'];
        }

        if (isset($input['refresh_token'])) {
            $this->refreshToken = $input['refresh_token'];
        }

        if (isset($input['expires_in'])) {
            $this->expiresIn = Carbon::parse($input['expires_in']);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'  => $this->id,
            'access_token'  => $this->accessToken,
            'refresh_token' => $this->refreshToken,
            'expires_in'    => $this->expiresIn,
        ];
    }
}
