<?php

use Faker\Generator as Faker;
use App\File;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'cover_id' => function ($faker) {
          return factory(File::class, 'cover')->create();
        },
        'sample_id' => function () {
          return factory(File::class, 'sample')->create();
        },
        'file_id' => function () {
          return factory(File::class, 'product_file')->create();
        },
        'title' => $faker->sentence,

        'body' => $faker->paragraph,

        'price' => $faker->randomFloat(2, 1, 999999.99),

        'user_id' => function() {
            return factory(\App\User::class)->create()->id;
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
