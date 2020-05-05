<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Producer;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $category_id = Category::all()->pluck('id');
    $producer_id = Producer::all()->pluck('id');
    return [
        'name' => $faker->name,
        'category_id' => $faker->randomElement($category_id),
        'producer_id' => $faker->randomElement($producer_id),
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'amount' => $faker->numberBetween($min = 10, $max = 30),
        'price' => $faker->numberBetween($min = 100, $max = 2000),
    ];
});
