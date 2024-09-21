<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add user admin and set is_admin to true
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), 
            'is_admin' => true,
        ]);
        
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