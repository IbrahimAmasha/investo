<?php

namespace Database\Factories;

use App\Models\Post;
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
        return [
 
            'content' => $this->faker->paragraph,
            'likes_count' => $this->faker->numberBetween(0, 50),
            'user_id' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected'])
        ];
    }
}
