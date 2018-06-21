<?php

use Faker\Generator as Faker;

$factory->define(\App\File::class, function (Faker $faker) {
    return [
        'product_id' => null,
        'assoc' => '',
        'path' => ''
    ];
});

$factory->state(\App\File::class, 'cover', function (Faker $faker) {
    $path = app()->environment('testing')
        ? ''
        : (new \Illuminate\Http\UploadedFile(
            $faker->image(
                null,
                640, 480,
                'abstract'
            ),
            'product-cover'
        ))->store('product_covers', 'public');

    return [
        'assoc' => 'cover',
        'path' => $path
    ];
});


$factory->state(\App\File::class, 'sample', function (Faker $faker) {
    $path = app()->environment('testing')
        ? ''
        : \Illuminate\Http\UploadedFile::fake()->create('product-sample')
            ->store('product_samples', 'public');

    return [
        'assoc' => 'sample',
        'path' => $path
    ];
});

$factory->state(\App\File::class, 'product_file', function (Faker $faker) {
    $path = app()->environment('testing')
        ? ''
        : \Illuminate\Http\UploadedFile::fake()->create('product-file')
            ->store('product_files');

    return [
        'assoc' => 'product-file',
        'path' => $path
    ];
});

