<?php

namespace Database\Seeders;

use App\Models\Land;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* \App\Models\Land::factory()->create([
            'name' => 'Le Domaine de Valombreuse',
            'owner' => 'Khalee.voxel',
            'presentation' => 'Si vous aimez les iles veuillez lire cet article',
            'description' => 'Une map située dans les iles carraibes avec 7 maisons et un complexe hotellier, chaque maison dispose d\'une piscine',
            'group' => 'Le Domaine de Valombreuse',
            'prims' => '9000',
            'remaining_prims' => '1500',
            'date_buy' => '2022-04-15',  
        ]);

        \App\Models\Land::factory(5)->create();*/

        // create land
        $lands = Land::factory()->count(5)->create();
        // create pictures for land
        foreach ($lands as $land) {
            $pictures = Picture::factory()->count(4)->create();
            $pictureFavori = Picture::factory()->count(1)->create([
                'favori' => true
            ]);
            $land->pictures()->saveMany($pictures);
            $land->pictures()->save($pictureFavori[0]);
        }
    }
}
