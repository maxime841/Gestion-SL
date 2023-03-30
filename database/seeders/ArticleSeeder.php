<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Article;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shops = Shop::all();
        foreach ($shops as $shop) {
            // create Article
            $articles = Article::factory()->count(5)->create();
            // create pictures for article
            foreach ($articles as $article) {
                $pictures = Picture::factory()->count(4)->create();
                 $pictureFavori = Picture::factory()->count(1)->create([
                'favori' => true
                ]);
            $article->pictures()->saveMany($pictures);
            $article->pictures()->save($pictureFavori[0]);
            }
        $shop->parties()->saveMany($articles);
        }
    }
}
