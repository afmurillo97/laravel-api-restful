<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->text(1600)
        ];
    }
}
