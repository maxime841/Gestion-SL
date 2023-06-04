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
            DjSeeder::class,
            DancerSeeder::class,
            HostSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PictureSeeder::class,
            ShopSeeder::class,
            ArticleSeeder::class,
            HobbySeeder::class,
            ActivitySeeder::class,
            CommentaireSeeder::class,
            LandSeeder::class,
            HouseSeeder::class,
            TenantSeeder::class,
        ]);
    }
}
