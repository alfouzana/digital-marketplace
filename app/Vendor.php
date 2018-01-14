<?php

namespace App;

use App\Enums\UserTypes;

class Vendor extends User
{
    protected static $singleTableType = UserTypes::VENDOR;
}
