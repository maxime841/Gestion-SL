<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Party;
use App\Models\Dancer;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DancerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clubs = Club::all();
        $parties = Party::all();
        foreach ($clubs as $club) {
            foreach ($parties as $party) {
            // create dancers
            $dancers = Dancer::factory()->count(5)->create();
            // create pictures for dancers
                foreach ($dancers as $dancer) {
                    $pictures = Picture::factory()->count(4)->create();
                     $pictureFavori = Picture::factory()->count(1)->create([
                    'favori' => true
                    ]);
                $dancer->pictures()->saveMany($pictures);
                $dancer->pictures()->save($pictureFavori[0]);
                } 
                $party->dancers()->saveMany($dancers);
            }  
            $club->dancers()->saveMany($dancers);
        }
    }
}
