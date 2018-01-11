<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,

        'cover_path' => str_after(
            $faker->image(
                product_covers_path(),
                640, 480,
                'abstract'
            ),
            public_path().DIRECTORY_SEPARATOR
        ),

        'body' => $faker->paragraph,

        'price' => $faker->randomFloat(2, 0, 100000000),

        'sample_path' => str_after(
            $faker->file(
                product_covers_path(),
                product_samples_path()
            ),
            public_path().DIRECTORY_SEPARATOR
        ),

        'file_path' => str_after(
            $faker->file(
                product_covers_path(),
                product_files_path()
            ),
            resource_path().DIRECTORY_SEPARATOR
        ),

        'user_id' => function() {
            $vendor = factory(\App\User::class)->create([
                'type' => \App\Enums\UserTypes::VENDOR,
            ]);

            return $vendor->id;
        },

        'category_id' => function() {
            return factory(\App\Category::class)->create()->id;
        },
    ];
});
