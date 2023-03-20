<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\Role;

interface RoleRegisterContract
{
    public function selectRoleForRegister(string|null $idRole): Role;
}
