<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\User;

interface UserRegisterContract
{
    public function registerUser(array $input): User;
}
