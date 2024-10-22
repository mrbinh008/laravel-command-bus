<?php

namespace App\Commands\Auth;

use Spatie\LaravelData\Data;

class LogoutCommand extends Data
{
    public function __construct(
        #[]
       public string $tokenId,
    )
    {
    }
}
