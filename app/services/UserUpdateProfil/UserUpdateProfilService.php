<?php

declare(strict_types=1);

namespace App\Services\UserUpdateProfil;

use App\Models\User;
use App\Services\UserFill\UserFillService;
use App\Services\Contracts\UserUpdateProfilContract;

class UserUpdateProfilService implements UserUpdateProfilContract
{
    /**
     * instance of UserFillService
     *
     * @var [type]
     */
    public $userFillService;

    /**
     * init class
     */
    public function __construct()
    {
        $this->userFillService = new UserFillService();
    }

    /**
     * update profil's user current
     *
     * @param User $user
     * @param array $input
     * @return void
     */
    public function userUpdateProfil(User $user, array $input): User
    {
        $userUpdated = $user->forceFill($this->userFillService->fillUserUpdateProfil($input));
        $userUpdated->save();
        return $userUpdated;
    }

    /**
     * update profil's user current with change email
     *
     * @param User $user
     * @param array $input
     * @return User
     */
    public function userUpdateProfilVerifiedEmail(User $user, array $input): User
    {
        $userUpdated = $user->forceFill($this->userFillService
            ->fillUserUpdateProfilVerifiedEmail($input));
        $userUpdated->save();
        $userUpdated->sendEmailVerificationNotification();
        return $userUpdated;
    }
}
