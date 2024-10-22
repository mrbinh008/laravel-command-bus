<?php

namespace App\Commands\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class LoginCommand extends Data
{
    public function __construct(
        #[StringType, Email, Exists('users', 'email')]
        public string $email,
        public string $password,
    )
    {
    }
}
