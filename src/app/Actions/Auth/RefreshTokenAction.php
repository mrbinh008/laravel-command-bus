<?php

namespace App\Actions\Auth;

use App\Traits\GetTokenTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Passport\Exceptions\AuthenticationException;

class RefreshTokenAction
{
    use GetTokenTrait;

    /**
     * @throws AuthenticationException
     * @throws Exception
     */
    public function handle(string $token): Collection
    {
        $request = Request::create(route('passport.token'), 'POST', [
            'refresh_token' => $token,
            'client_id' => config('passport.password_client.id'),
            'client_secret' => config('passport.password_client.secret'),
            'grant_type' => 'refresh_token',
        ]);

        return self::getToken($request);
    }
}
