<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,

        'cover_path' => str_after(
            $faker->image(
                PRODUCT_COVERS_DIR,
                640, 480,
                'abstract'
            ),
            public_path().DIRECTORY_SEPARATOR
        ),

        'body' => $faker->paragraph,

        'price' => $faker->randomFloat(2, 0, 100000000),

        'sample_path' => str_after(
            $faker->file(
                PRODUCT_COVERS_DIR,
                PRODUCT_SAMPLES_DIR
            ),
            public_path().DIRECTORY_SEPARATOR
        ),

        'file_path' => str_after(
            $faker->file(
                PRODUCT_COVERS_DIR,
                PRODUCT_FILES_DIR
            ),
            resource_path().DIRECTORY_SEPARATOR
        ),

        'user_id' => function() {
            return factory(\App\User::class)->create()->id;
        },

        'category_id' => function() {
            return factory(\App\Category::class)->create()->id;
        },
    ];
});
