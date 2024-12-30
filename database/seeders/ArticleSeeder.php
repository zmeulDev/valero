<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;

class ArticleSeeder extends Seeder
{

    public function run(): void
    {
        // generate 20 random article no duplicate slug
        Article::factory()->count(5)->create();  
        User::factory()->count(4)->create();  
    }
}