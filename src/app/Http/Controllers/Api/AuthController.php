<?php

namespace App\Http\Controllers\Api;

use App\Commands\Auth\LoginCommand;
use App\Commands\Auth\LogoutCommand;
use App\Commands\Auth\RefreshTokenCommand;
use App\Handlers\Auth\LoginHandler;
use App\Handlers\Auth\LogoutHandler;
use App\Handlers\Auth\RefreshTokenHandler;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('auth')]
class AuthController extends Controller
{
    public function __construct(
        private readonly LoginHandler        $loginHandler,
        private readonly RefreshTokenHandler $refreshTokenHandler,
        private readonly LogoutHandler       $logoutHandler,
    )
    {
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Post('login', name: 'auth.login')]
    public function login(Request $request): JsonResponse
    {
        $payload = LoginCommand::from([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        $result = Bus::dispatchNow($payload, $this->loginHandler);

        return $this->responseOk($result);
    }

    /**
     * Handle a refresh token request to the application.
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Post('refresh-token', name: 'auth.refresh-token')]
    public function refreshToken(Request $request): JsonResponse
    {
        $payload = RefreshTokenCommand::from([
            'refresh_token' => $request->input('refresh_token'),
        ]);

        $result = Bus::dispatchNow($payload, $this->refreshTokenHandler);

        return $this->responseOk($result);
    }

    /**
     * Handle a logout request to the application.
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Post('logout', name: 'auth.logout', middleware: 'auth:api')]
    public function logout(Request $request): JsonResponse
    {
        $payload = LogoutCommand::from([
            'tokenId' => $request->user()?->token()?->id,
        ]);
        Bus::dispatchNow($payload, $this->logoutHandler);

        return $this->responseOk();
    }
}
