<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * @return array
     * @throws \JsonException
     */
    public function definition()
    {
        return [
            'label'             => $this->faker->name(),
            'comment'           => $this->faker->sentence(),
            'difficulty'        => $this->faker->randomElement(['easy', 'hard']),
            'amount'            => $this->faker->randomFloat(2),
            'active'            => $this->faker->boolean(),
            'options'           => json_encode([$this->faker->name() => $this->faker->name()], JSON_THROW_ON_ERROR | true),
            'category_id'       => Category::all()->random()->id,
        ];
    }
}
