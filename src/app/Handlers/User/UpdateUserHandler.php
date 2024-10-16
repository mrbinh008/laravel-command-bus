<?php

namespace App\Handlers\User;

use App\Actions\User\UpdateUserAction;
use App\Commands\User\UpdateUserCommand;

readonly class UpdateUserHandler
{
    public function __construct(
        private UpdateUserAction $updateUserAction,
    )
    {
    }

    public function handle(UpdateUserCommand $command): int
    {
        return $this->updateUserAction->handle($command->user,$command->except('user')->toArray());
    }
}
