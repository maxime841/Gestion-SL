<?php

namespace Database\Seeders;

use App\Models\Hobby;
use App\Models\Picture;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = Hobby::all();
        foreach ($hobbies as $hobby) {
            // create Activity
            $activities = Activity::factory()->count(5)->create();
            // create pictures for activities
            foreach ($activities as $activity) {
                $pictures = Picture::factory()->count(4)->create();
                 $pictureFavori = Picture::factory()->count(1)->create([
                'favori' => true
                ]);
            $activity->pictures()->saveMany($pictures);
            $activity->pictures()->save($pictureFavori[0]);
            }
        $hobby->articles()->saveMany($activities);
        }
    }
}
