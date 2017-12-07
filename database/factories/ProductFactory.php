<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,

        'cover_path' => str_after(
            $faker->image(
                public_path('uploads/product_covers'),
                640, 480,
                'abstract'
            ),
            public_path().DIRECTORY_SEPARATOR
        ),

        'body' => $faker->paragraph,

        'price' => $faker->randomFloat(2, 0, 100000000),

        'sample_path' => str_after(
            $faker->file(
                public_path('uploads/product_covers'),
                public_path('uploads/product_samples')
            ),
            public_path().DIRECTORY_SEPARATOR
        ),

        'file_path' => str_after(
            $faker->file(
                public_path('uploads/product_covers'),
                resource_path('uploads/product_files')
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
