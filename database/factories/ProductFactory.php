<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,

        'cover_path' => '',

        'body' => $faker->paragraph,

        'price' => $faker->randomFloat(2, 0, 100000000),

        'sample_path' => '',

        'file_path' => '',

        'user_id' => function() {
            return factory(\App\Vendor::class)->create()->id;
        },

        'category_id' => function() {
            return factory(\App\Category::class)->create()->id;
        },
    ];
});

$factory->defineAs(\App\Product::class, 'details', function(Faker $faker) {
   return array_only(factory(\App\Product::class)->raw(), [
       'title',
       'body',
       'price',
       'category_id'
   ]);
});