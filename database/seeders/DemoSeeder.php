<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // call seeder for categories
        $this->call([
            CategorySeeder::class,
        ]);

        // call seeder for articles
        $this->call([
            ArticleSeeder::class,
        ]);
    }
}
