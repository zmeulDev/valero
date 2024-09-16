<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        return [
            'user_id' => 1,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(3, true), // Generates 3 paragraphs
            'is_published' => true, // Set this to true for published posts
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id, // Assuming posts are linked to categories
        ];
    }
}
