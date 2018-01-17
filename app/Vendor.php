<?php

namespace App;

use App\Enums\UserTypes;

class Vendor extends User
{
    protected static $singleTableType = UserTypes::VENDOR;

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }
}
