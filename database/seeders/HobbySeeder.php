<?php

namespace Database\Seeders;

use App\Models\Hobby;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create Hobby
        $hobbies = Hobby::factory()->count(5)->create();
        // create pictures for hobby
        foreach ($hobbies as $hobby) {
            $pictures = Picture::factory()->count(4)->create();
            $pictureFavori = Picture::factory()->count(1)->create([
                'favori' => true
            ]);
            $hobby->pictures()->saveMany($pictures);
            $hobby->pictures()->save($pictureFavori[0]);
        }
    }
}
