<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Price;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_number'=> $this->faker->randomNumber(8,true),
            'user_id'=> function () {
                return User::factory()->create()->id;
            },
            'product_id' => function() {
                return Price::factory()->create()->id;
            },
            'currency_id'=>$this->faker->numberBetween(1,2),
            'amount'=>$this->faker->randomDigitNotNull
        ];
    }
}
