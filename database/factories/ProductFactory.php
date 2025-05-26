<?php

namespace Database\Factories;


use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'brand' => $this->faker->randomElement(['Casio', 'Rolex', 'Fossil', 'Seiko']),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => 'default.jpg',
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}

