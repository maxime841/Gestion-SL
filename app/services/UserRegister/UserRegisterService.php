<?php

declare(strict_types=1);

namespace App\Services\UserRegister;

use App\Models\User;
use App\Services\Contracts\UserRegisterContract;
use App\Services\RoleRegister\RoleRegisterService;
use App\Services\UserFill\UserFillService;

class UserRegisterService implements UserRegisterContract
{
    /**
     * instance RoleRegisterService
     *
     * @var [RoleRegisterService]
     */
    public $roleRegisterService;

    /**
     * instance UserFillService
     *
     * @var [UserFillService]
     */
    public $userFillService;

    /**
     * init class
     */
    public function __construct()
    {
        $this->roleRegisterService = new RoleRegisterService();
        $this->userFillService = new UserFillService();
    }

    /**
     * create user with role
     *
     * @param array $input
     * @return User
     */
    public function registerUser(array $input): User
    {
        // get role
        $role = $this->roleRegisterService->selectRoleForRegister($input['role'] ?? null);
        // create user
        $user = User::create($this->userFillService->fillRegister($input));
        // add role for user
        $role->users()->save($user);
        return $user;
    }
}
