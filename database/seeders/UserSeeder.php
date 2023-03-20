<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Role;
use App\Models\User;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    // get roles
    $idRoleRoot = Role::select('id')->where('libelle', '=', 'root')->get();
    $roleAdmin = Role::where('libelle', '=', 'admin')->get();
    $roleManageClub = Role::where('libelle', '=', 'managerclub')->get();
    $roleManageDancer = Role::where('libelle', '=', 'managerdancer')->get();
    $roleManageDj = Role::where('libelle', '=', 'managerdj')->get();
    $roleAuth = Role::where('libelle', '=', 'auth')->get();
    $rolePublic = Role::where('libelle', '=', 'public')->get();

      // create user with role root
      User::factory()->create([
        // 'first_name' => 'john',
        // 'last_name' => 'haimez',
        // 'pseudo' => 'john_dev',
        'name' => 'Madmax3184',
        // 'address' => '1 rue de la paix',
        // 'code_post' => '75000',
        // 'city' => 'paris',
        // 'phone' => '0606060606',
        'avatar' => null,
        'email' => 'maxime841@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => $idRoleRoot[0]->id,
        'remember_token' => null,
    ]);

    // create user with role admin
    $usersAdmin = User::factory()->count(5)->create();
    foreach ($usersAdmin as $user) {
        $roleAdmin[0]->users()->save($user);
    };
    // create user with role managerclub
    $userManagerClub = User::factory()->count(5)->create();
    foreach ($userManagerClub as $user) {
        $roleManageClub[0]->users()->save($user);
    };
    // create user with role managerdancer
    $userManagerDancer = User::factory()->count(5)->create();
    foreach ($userManagerDancer as $user) {
        $roleManageDancer[0]->users()->save($user);
    };
    // create user with role managerdj
    $userManagerDj = User::factory()->count(5)->create();
    foreach ($userManagerDj as $user) {
        $roleManageDj[0]->users()->save($user);
    };
    // create user with role auth
    $usersAuth = User::factory()->count(5)->create();
    foreach ($usersAuth as $user) {
        $roleAuth[0]->users()->save($user);
    };
    // create user with role public
    $usersPublic = User::factory()->count(5)->create();
    foreach ($usersPublic as $user) {
        $rolePublic[0]->users()->save($user);
    };
    }
}
