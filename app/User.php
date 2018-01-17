<?php

namespace App;

use App\Enums\UserTypes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

class User extends Authenticatable
{
    use Notifiable, SingleTableInheritanceTrait;

    protected $table = 'users';

    protected static $singleTableTypeField = 'type';

    protected static $singleTableSubclasses = [
        Admin::class,
        Vendor::class,
        Customer::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $typesToHomePaths = [
        UserTypes::ADMIN => '/admin',
        UserTypes::VENDOR => '/vendor',
        UserTypes::CUSTOMER => '/customer'
    ];

    public function homeUrl()
    {
        return url($this->typesToHomePaths[$this->getAttribute('type')]);
    }
}
