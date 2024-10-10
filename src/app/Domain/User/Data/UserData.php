<?php

namespace App\Domain\User\Data;

use App\Infrastructure\Database\Models\User;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
    )
    {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            name: $user->name,
            email: $user->email
        );
    }
}
