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
        // randomise out of stock status
        $options = array(0, 1);

        return [
            'name' => $this->faker->words(3, true),
            'color' => $this->faker->word(),
            'type' => $this->faker->word(),
            'size' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2,1,100),
            // use default image provided
            'image' => '../../images/seed-image.jpg',
            'out_of_stock' => $options[array_rand($options)]
        ];
    }
}
