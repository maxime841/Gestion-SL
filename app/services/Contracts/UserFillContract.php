<?php

declare(strict_types=1);

namespace App\Services\Contracts;

interface UserFillContract
{
    public function fillRegister(array $input);
    public function fillUserUpdateProfil(array $input);
    public function fillUserUpdateProfilVerifiedEmail(array $input);
}
