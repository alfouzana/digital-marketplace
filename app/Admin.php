<?php

namespace App;

use App\Enums\UserTypes;

class Admin extends User
{
    protected static $singleTableType = UserTypes::ADMIN;
}
