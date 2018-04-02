<?php

use Faker\Generator as Faker;

$factory->define(\App\File::class, function (Faker $faker) {
    return [
        'product_id' => null,
        'assoc' => '',
        'path' => ''
    ];
});

$factory->state(\App\File::class, 'cover', [
    'assoc' => 'cover'
]);


$factory->state(\App\File::class, 'sample', [
        'assoc' => 'sample'
]);

//$factory->state(\App\File::class, 'main', [
//        'assoc' => 'main'
//]);

