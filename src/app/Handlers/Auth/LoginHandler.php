<?php

namespace App\Handlers\Auth;

use App\Actions\Auth\LoginAction;
use App\Commands\Auth\LoginCommand;
use Exception;
use Illuminate\Support\Collection;

readonly class LoginHandler
{
    public function __construct(
        private LoginAction $loginAction,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function handle(LoginCommand $command): Collection
    {
        return $this->loginAction->handle($command->toArray());
    }
}
