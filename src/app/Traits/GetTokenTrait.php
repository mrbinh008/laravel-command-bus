<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Passport\Exceptions\AuthenticationException;

trait GetTokenTrait
{
    /**
     * @throws AuthenticationException
     * @throws Exception
     */
    public static function getToken(Request $request): Collection
    {
        $result = app()->handle($request);
        $response = json_decode($result->getContent(), true);
        if (isset($response['error']) || !isset($response['access_token'])) {
            throw new AuthenticationException($response['message']);
        }

        return collect([
            'access_token' => $response['access_token'],
            'refresh_token' => $response['refresh_token'],
            'expires_in' => $response['expires_in'],
        ]);
    }
}
