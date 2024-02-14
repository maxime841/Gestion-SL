<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Host;
use App\Models\Party;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        /*$clubs = Club::all();
        $parties = Party::all();
        foreach ($clubs as $club) {
            foreach ($parties as $party) {
            // create hosts
            $hosts = Host::factory()->count(5)->create();
            // create pictures for host
                foreach ($hosts as $host) {
                    $pictures = Picture::factory()->count(4)->create();
                     $pictureFavori = Picture::factory()->count(1)->create([
                    'favori' => true
                    ]);
                $host->pictures()->saveMany($pictures);
                $host->pictures()->save($pictureFavori[0]);
                } 
                $party->hosts()->saveMany($hosts);
            }  
            $club->hosts()->saveMany($hosts);
        }
    }*/

     // create club
     $hosts = Host::factory()->count(5)->create();
     // create pictures for host
     foreach ($hosts as $host) {
         $pictures = Picture::factory()->count(4)->create();
         $pictureFavori = Picture::factory()->count(1)->create([
             'favori' => true
         ]);
         $host->pictures()->saveMany($pictures);
         $host->pictures()->save($pictureFavori[0]);
        }
    }
}
