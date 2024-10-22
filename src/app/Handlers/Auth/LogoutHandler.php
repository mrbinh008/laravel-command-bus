<?php

namespace App\Handlers\Auth;

use App\Actions\Auth\LogoutAction;
use App\Commands\Auth\LogoutCommand;
use Exception;

readonly class LogoutHandler
{
    public function __construct(
        private LogoutAction $logoutAction,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(LogoutCommand $command): void
    {
        $this->logoutAction->handle($command->tokenId);
    }
}
