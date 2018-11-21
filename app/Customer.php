<?php

namespace App;

use App\Enums\UserTypes;

class Customer extends User
{
    protected static $singleTableType = UserTypes::CUSTOMER;

    public function purchasedProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'purchases',
            'user_id'
        );
    }
}
