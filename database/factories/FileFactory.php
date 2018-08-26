<?php

use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(\App\File::class, function (Faker $faker) {
    return [
        'product_id' => null,
        'assoc' => '',
        'path' => ''
    ];
});

$stateDependantFileAttributes = function ($assoc, $disk, $dir, Closure $callback) {
    list($path, $original_name, $size) = app()->environment('testing') ?
        ['', '', 0] : [
            with($file = $callback())->store($dir, $disk),
            $file->getClientOriginalName(),
            $file->getSize()
        ];

    return compact('assoc', 'path', 'original_name', 'size');
};

$factory->state(\App\File::class, 'cover', function (Faker $faker) use ($stateDependantFileAttributes) {
    return  $stateDependantFileAttributes('cover', 'public', 'product_covers', function () use ($faker) {
        return new UploadedFile(
            $faker->image(
                null,
                640, 480,
                'abstract'
            ),
            'cover.jpeg'
        );
    });
});


$factory->state(\App\File::class, 'sample', function (Faker $faker) use ($stateDependantFileAttributes) {
    return $stateDependantFileAttributes('sample', 'public', 'product_samples', function () use ($faker) {
        return UploadedFile::fake()->create('sample.bin', 500);
    });
});

$factory->state(\App\File::class, 'product_file', function (Faker $faker) use($stateDependantFileAttributes) {
    return $stateDependantFileAttributes('product_file', 'local', 'product_files', function () use ($faker) {
        return UploadedFile::fake()->create('sample.bin', 1000);
    });
});

