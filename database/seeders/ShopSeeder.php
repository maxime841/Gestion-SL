<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create shop
        $shops = Shop::factory()->count(5)->create();
        // create pictures for shop
        foreach ($shops as $shop) {
            $pictures = Picture::factory()->count(4)->create();
            $pictureFavori = Picture::factory()->count(1)->create([
                'favori' => true
            ]);
            $shop->pictures()->saveMany($pictures);
            $shop->pictures()->save($pictureFavori[0]);
        }
    }
}
