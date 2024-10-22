<?php

namespace App\Handlers\Auth;

use App\Actions\Auth\RefreshTokenAction;
use App\Commands\Auth\RefreshTokenCommand;
use Exception;
use Illuminate\Support\Collection;

readonly class RefreshTokenHandler
{
    public function __construct(
        private RefreshTokenAction $refreshTokenAction,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(RefreshTokenCommand $command): Collection
    {
        return $this->refreshTokenAction->handle($command->refreshToken);
    }
}
