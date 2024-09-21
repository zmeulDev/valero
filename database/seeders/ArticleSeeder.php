<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{

    public function run(): void
    {
        // generate 20 random article no duplicate slug
        Article::factory()->count(20)->create();    
    }
}