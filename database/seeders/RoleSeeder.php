<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Role;
use App\Models\User;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    // create role
    Role::factory()->create([
        'libelle' => 'root',
    ],);
    Role::factory()->create([
        'libelle' => 'admin',
    ],);
    Role::factory()->create([
        'libelle' => 'managershop',
    ],);
    Role::factory()->create([
        'libelle' => 'managerhobby',
    ],);
    Role::factory()->create([
        'libelle' => 'managerclub',
    ],);
    Role::factory()->create([
        'libelle' => 'managerdancer',
    ],);
    Role::factory()->create([
        'libelle' => 'managerdj',
    ],);
    Role::factory()->create([
        'libelle' => 'auth',
    ],);
    Role::factory()->create([
        'libelle' => 'public',
    ],);
    }
}
