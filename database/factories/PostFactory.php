<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();

        return [
            'id' => Str::uuid(),
            'slug' => Str::slug($title),
            'title' => $title,
            'excerpt' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'published' => true,
            'featured_image_caption' => $this->faker->image(storage_path('app/public/wink')),
            'author_id' => Author::factory()->create(),
        ];
    }

    /**
     * Indicate that the post is unpublished.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unpublished()
    {
        return $this->state(function () {
            return [
                'published' => false,
            ];
        });
    }
}
