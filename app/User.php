<?php

namespace App;

use App\Enums\UserTypes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function isVendor()
    {
        return $this->type == UserTypes::VENDOR;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
