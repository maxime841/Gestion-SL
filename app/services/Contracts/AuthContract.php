<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Http\JsonResponse;

interface AuthContract
{
    public function accessToken(User $user, $password): JsonResponse;
    public function accessTokenVerified(User $user, $password): JsonResponse;
}
