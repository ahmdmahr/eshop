<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'slug'=>$this->faker->unique()->slug,
            //if set to true, the method returns a single string where the sentences are concatenated and separated by spaces. If set to false (the default), it returns an array of sentences.
            'summary'=>$this->faker->sentences(3,true),
            //generate a random one color photo with specific width & height
            'photo'=>$this->faker->imageUrl('100','100'),
            'is_parent'=>$this->faker->randomElement([true,false]),
            /*
            pluck function return without toArray:

            Illuminate\Support\Collection {
                #items: [
                    0 => 1,
                    1 => 2,
                    2 => 3,
                    3 => 4,
                ]
            } 

            and this is faster because it use map ds

            with:

            [
                1,
                2,
                3,
                4,
            ]

            */
            'parent_id'=>$this->faker->randomElement(Category::pluck('id')->toArray()),
            'status'=>$this->faker->randomElement(['active','inactive'])
        ];
    }
}
