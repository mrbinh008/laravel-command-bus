<?php

namespace App\Actions\Auth;

use Carbon\Carbon;
use Exception;
use Laravel\Passport\Exceptions\AuthenticationException;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class LogoutAction
{
    /**
     * @throws Exception
     */
    public function handle($tokenId): void
    {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $token = $tokenRepository->find($tokenId);

        if ($token && Carbon::parse($token->expires_at)->isPast()) {
            throw new AuthenticationException('Token has expired');
        }

        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
    }
}
