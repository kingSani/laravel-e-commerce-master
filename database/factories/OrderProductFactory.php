<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'name' => $this->faker->words(3, true),
            'color' => $this->faker->word(),
            'type' => $this->faker->word(),
            'size' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2,1,100),
            // use default image provided
            'image' => '../../images/seed-image.jpg',
            'quantity' => $this->faker->randomDigitNot(0),
        ];
    }
}
