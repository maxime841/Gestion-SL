<?php

namespace Database\Seeders;

use App\Models\Dj;
use App\Models\Club;
use App\Models\Party;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       /* $clubs = Club::all();
        $parties = Party::all();
        foreach ($clubs as $club) {
            foreach ($parties as $party) {
            // create dj
            $djs = Dj::factory()->count(5)->create();
            // create pictures for dj
                foreach ($djs as $dj) {
                    $pictures = Picture::factory()->count(4)->create();
                     $pictureFavori = Picture::factory()->count(1)->create([
                    'favori' => true
                    ]);
                $dj->pictures()->saveMany($pictures);
                $dj->pictures()->save($pictureFavori[0]);
                } 
                $party->djs()->saveMany($djs);
            }  
            $club->djs()->saveMany($djs);
        }
    }*/

     // create club
     $djs = Dj::factory()->count(5)->create();
     // create pictures for club
     foreach ($djs as $dj) {
         $pictures = Picture::factory()->count(4)->create();
         $pictureFavori = Picture::factory()->count(1)->create([
             'favori' => true
         ]);
         $dj->pictures()->saveMany($pictures);
         $dj->pictures()->save($pictureFavori[0]);
        }
    }
}