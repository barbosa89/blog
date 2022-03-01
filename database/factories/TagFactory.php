<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->word;

        return [
            'id' => Str::uuid(),
            'slug' => Str::slug($name),
            'name' => $name,
        ];
    }
}
