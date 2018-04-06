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
        : str_after(
            $faker->image(
                product_covers_path(),
                640, 480,
                'abstract'
            ),
            public_path().DIRECTORY_SEPARATOR
        );

    return [
        'assoc' => 'cover',
        'path' => $path
    ];
});


$factory->state(\App\File::class, 'sample', function (Faker $faker) {
    $path = app()->environment('testing')
        ? ''
        : str_after(
            \Illuminate\Http\UploadedFile::fake()->create('product-sample')
            ->move(product_samples_path(), uniqid())->getRealPath(),
            public_path().DIRECTORY_SEPARATOR
        );

    return [
        'assoc' => 'sample',
        'path' => $path
    ];
});

//$factory->state(\App\File::class, 'main', [
//        'assoc' => 'main'
//]);

