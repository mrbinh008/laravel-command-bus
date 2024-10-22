<?php

namespace App\Actions\Auth;

use App\Traits\GetTokenTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LoginAction
{
    use GetTokenTrait;

    /**
     * @throws Exception
     */
    public function handle(array $payload): Collection
    {
        $request = Request::create(route('passport.token'), 'POST', [
            'grant_type' => 'password',
            'client_id' => config('passport.password_client.id'),
            'client_secret' => config('passport.password_client.secret'),
            'username' => $payload['email'],
            'password' => $payload['password'],
            'scope' => '',
        ]);

        return self::getToken($request);
    }
}
