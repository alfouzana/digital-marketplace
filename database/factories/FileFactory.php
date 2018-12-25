<?php

use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->defineAs(\App\File::class, 'cover', function (Faker $faker) {
    $name = $faker->word;

    $file = app()->environment('testing') ?
            UploadedFile::fake()->image($name.'.jpeg'):
            new UploadedFile(
                $faker->image(
                    null,
                    640, 480,
                    'abstract'
                ),
                $name.'.jpeg'
            );

    return file_attributes('cover', 'public', 'product_covers', $file);
});


$factory->defineAs(\App\File::class, 'sample', function (Faker $faker) {
    $file = UploadedFile::fake()->create($faker->word, 500);

    return file_attributes('sample', 'public', 'product_samples', $file);
});

$factory->defineAs(\App\File::class, 'product_file', function (Faker $faker) {
    $file = UploadedFile::fake()->create($faker->word, 1000);

    return file_attributes('product_file', 'local', 'product_files', $file);
});
