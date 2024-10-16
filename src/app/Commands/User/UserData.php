<?php

namespace App\Commands\User;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public string $name;
    public string $email;
}
