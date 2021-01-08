<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>$this->faker->sentence(1),
            'description' =>$this->faker->sentence(10,false),
            'image' => $this->faker->regexify('images/pizza_[1-8]{1}\.png')
        ];
    }
}
