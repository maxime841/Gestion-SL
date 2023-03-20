<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Picture::factory()->create([
            'name' => 'club 1',
            'picture_url' => 'url1',
            'favori' => 'true', 
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'club 2',
            'picture_url' => 'url2',
            'favori' => 'false',
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'dj 1',
            'picture_url' => 'url1',
            'favori' => 'false',
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'dj 2',
            'picture_url' => 'url2',
            'favori' => 'true',
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'dancer 1',
            'picture_url' => 'url1',
            'favori' => 'true',
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'dancer 2',
            'picture_url' => 'url2',
            'favori' => 'false',
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'host 1',
            'picture_url' => 'url1',
            'favori' => 'false',
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'host 2',
            'picture_url' => 'url2',
            'favori' => 'true',
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'party 1',
            'picture_url' => 'url1',
            'favori' => 'true',
        ]);

        \App\Models\Picture::factory()->create([
            'name' => 'party 2',
            'picture_url' => 'url2',
            'favori' => 'false',
        ]);
    }
}
