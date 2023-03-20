<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Creation des club dancer dj party
        $this->call([
            ClubSeeder::class,
            PartySeeder::class,
            DancerSeeder::class,
            DjSeeder::class,
            HostSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PictureSeeder::class,
        ]);
    }
}
