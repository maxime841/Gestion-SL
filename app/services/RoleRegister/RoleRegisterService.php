<?php

declare(strict_types=1);

namespace App\Services\RoleRegister;

use App\Models\Role;
use App\Services\Contracts\RoleRegisterContract;

class RoleRegisterService implements RoleRegisterContract
{
    /**
     * returns either the requested role or the auth role 
     *
     * @param string $idRole
     * @return Role
     */
    public function selectRoleForRegister(string|null $idRole): Role
    {
        if ($idRole) {
            return Role::find($idRole);
        } else {
            return Role::query()->where('libelle', '=', 'public')->firstOrFail();
        }
    }
}
