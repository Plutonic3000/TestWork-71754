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
            'title' => $this->faker->realText(20),
            'descr' => $this->faker->realText(100),
            'created_at' => date('Y-m-d H:i:s', strtotime('-'.rand(1,10).' minutes')),
            'updated_at' => now(),
        ];
    }
}
