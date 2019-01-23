<?php

use Faker\Generator as Faker;

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
        'user_id' => function () {
        	return factory(App\User::class)->create();
        },
        'product_id' => function () {
        	return factory(App\Product::class)->create([
        		'approval_status' => Mtvs\EloquentApproval\ApprovalStatuses::APPROVED,
        	]);
        },
        'amount' => $faker->randomFloat(2, 9.99, 999999.99),
    ];
});
