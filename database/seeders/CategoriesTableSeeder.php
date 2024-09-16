<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create categories
        Category::create([
            'name' => 'Work',
            'slug' => 'work',
        ]);

        Category::create([
            'name' => 'Life',
            'slug' => 'life',
        ]);

        Category::create([
            'name' => 'Tech',
            'slug' => 'tech',
        ]);
    }
}
