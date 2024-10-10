<?php

namespace App\Application\Handlers;

use App\Application\Actions\UpdateUserAction;
use App\Domain\User\Data\UpdateUserData;

class UpdateUserHandler
{
    private UpdateUserAction $updateUserAction;

    public function __construct(UpdateUserAction $updateUserAction)
    {
        $this->updateUserAction = $updateUserAction;
    }

    public function handle(UpdateUserData $data): int
    {
        return $this->updateUserAction->handle($data->user, $data->except('user')->toArray());
    }
}
