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
    list($path, $original_name, $size) = app()->environment('testing') ?
        ['', '', 0] : [with($file = new \Illuminate\Http\UploadedFile(
                $faker->image(
                    null,
                    640, 480,
                    'abstract'
                ),
                $faker->uuid
            ))->store('product_covers', 'public'),
            $file->getClientOriginalName(),
            $file->getSize()
        ];

    $assoc = 'cover';

    return compact('assoc', 'path', 'original_name', 'size');
});


$factory->state(\App\File::class, 'sample', function (Faker $faker) {
    list($path, $original_name, $size) = app()->environment('testing') ?
        ['', '', 0] : [with($file = \Illuminate\Http\UploadedFile::fake()
            ->create($faker->uuid, 500))->store('product_samples', 'public'),
            $file->getClientOriginalName(),
            $file->getSize()
        ];

    $assoc = 'sample';

    return compact('assoc', 'path', 'original_name', 'size');
});

$factory->state(\App\File::class, 'product_file', function (Faker $faker) {
    list($path, $original_name, $size) = app()->environment('testing') ?
        ['', '', 0] : [with($file = \Illuminate\Http\UploadedFile::fake()
            ->create($faker->uuid, 1000))->store('product_files', 'local'),
            $file->getClientOriginalName(),
            $file->getSize()
        ];

    $assoc = 'product-file';

    return compact('assoc', 'path', 'original_name', 'size');
});

