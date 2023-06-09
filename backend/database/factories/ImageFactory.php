<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['App\Models\User', 'App\Models\Video']);

        $status = $this->faker->boolean();
        // $path =  $type == 'person' ? $this->faker->imageUrl(640, 480, 'avatar', true) : $this->faker->imageUrl(640, 480, 'abstract', true);
        // $imageabelId = $type == "person" ?   User::all()->random()->id : Post::all()->random()->id;
        // if ($type == "person") {
        //     $useCase =  $this->faker->randomElement(["profile", "user", "customer"]);
        // } else if ($type = "post") {
        //     $useCase = "post";
        // } else {
        //     $useCase = "product";
        // }
        $path =  $this->faker->imageUrl(640, 480, 'avatar', true);
        $imageabelId = $this->faker->randomElement([User::all()->random()->id, Video::all()->random()->id]);
        $useCase = $type === "App\Models\User" ? $this->faker->randomElement(["profile", "user", "customer"]) : $this->faker->randomElement(["thumbnail", "thumbnail2"]);
        return [

            "name" => $this->faker->unique()->sentence(),
            "path" => $path,
            "size" => 2000000000,
            "width" => 500,
            "height" => 600,
            "status" => $status,
            "use_case" => $useCase,
            "imageable_id" => $imageabelId,
            "imageable_type" => $type
        ];
    }
}
