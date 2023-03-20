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
         // create host
         $hosts = Host::factory()->count(5)->create();
         // create pictures for club
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
