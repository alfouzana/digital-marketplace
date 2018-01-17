<?php

namespace App;

use App\Enums\UserTypes;

class Customer extends User
{
    protected static $singleTableType = UserTypes::CUSTOMER;
}
