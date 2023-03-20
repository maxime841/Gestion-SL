<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\User;

interface UserUpdateProfilContract
{
    public function userUpdateProfil(User $user, array $input): User;
    public function userUpdateProfilVerifiedEmail(User $user, array $input): User;
}
