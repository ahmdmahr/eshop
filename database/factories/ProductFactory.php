<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=>$this->faker->word(),
            'slug'=>$this->faker->unique()->slug(),
            'summary'=>$this->faker->text(),
            'description'=>$this->faker->paragraph(),
            'stock'=>$this->faker->numberBetween(0,100),
            'brand_id'=>$this->faker->randomElement(Brand::pluck('id')->toArray()),
            'category_id'=>$this->faker->randomElement(Category::pluck('id')->toArray()),
            'category_child_id'=>$this->faker->randomElement(Category::pluck('id')->toArray()),
            'vendor_id'=>$this->faker->randomElement(User::pluck('id')->toArray()),
            // generate a random float between 0 and 100 with 2 decimal places
            'price'=>$this->faker->randomFloat(2,0,10000),
            'offer_price'=>$this->faker->randomFloat(2,0,1000),
            'discount'=>$this->faker->randomFloat(2,0,100),
            'size'=>$this->faker->randomElement(['S','M','L','XL']),
            'condition'=>$this->faker->randomElement(['new','popular','winter']),
            'status'=>$this->faker->randomElement(['Active','Inactive'])
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Create associated ProductImages
            ProductImage::factory()->count(4)->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
