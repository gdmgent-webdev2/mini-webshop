<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = $this->faker->colorName . ' ' . $this->faker->city;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => $this->faker->randomNumber(4, false),
            'description' => $this->faker->paragraph(5),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
