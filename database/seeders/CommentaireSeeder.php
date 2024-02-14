<?php

namespace Database\Seeders;

use App\Models\Dj;
use App\Models\Club;
use App\Models\Host;
use App\Models\Picture;
use App\Models\Commentaire;
use Illuminate\Database\Seeder;

class CommentaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   $clubs = Club::all();
        foreach ($clubs as $club) {
            // create commentaire club
            $commentaires = Commentaire::factory()->count(3)->create();
            foreach($commentaires as $commentaire) {
                $pictureCommentaire = Picture::factory()->count(1)->create([
                    'favori' => true
                ]);
            $commentaire->pictures()->saveMany($pictureCommentaire);
            }
        $club->commentaires()->saveMany($commentaires);
        }  

        $djs = Dj::all();
        foreach ($djs as $dj) {
            // create commentaire dj
            $commentaires = Commentaire::factory()->count(1)->create();
            foreach($commentaires as $commentaire) {
                $pictureCommentaire = Picture::factory()->count(1)->create([
                    'favori' => true
                ]);
            $commentaire->pictures()->saveMany($pictureCommentaire);
            }
        $dj->commentaires()->saveMany($commentaires);
        }  

        $hosts = Host::all();
        foreach ($hosts as $host) {
            // create commentaire host
            $commentaires = Commentaire::factory()->count(1)->create();
            foreach($commentaires as $commentaire) {
                $pictureCommentaire = Picture::factory()->count(1)->create([
                    'favori' => true
                ]);
            $commentaire->pictures()->saveMany($pictureCommentaire);
            }
        $host->commentaires()->saveMany($commentaires);
        }  
    }   
}

