<?php

namespace App\Commands\User;

use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class UpdateUserCommand extends Data
{
    public function __construct(
        public User $user,
        #[StringType]
        public string $name,
        #[StringType, Email, Unique('users', 'email', ignore: new RouteParameterReference('user', 'id'))]
        public string $email,
    )
    {
    }
}
