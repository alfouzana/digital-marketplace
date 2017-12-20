<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentApproval\Approvable;
use Vinkla\Hashids\Facades\Hashids;

class Product extends Model
{
    use Sluggable, Approvable, SoftDeletes;

    public function getRouteKey()
    {
        return Hashids::encode(parent::getRouteKey());
    }

    public function resolveRouteBinding($value)
    {
        return parent::resolveRouteBinding(Hashids::decode($value));
    }

    public function url()
    {
        return url("/product/{$this->getAttribute('slug')}/{$this->getRouteKey()}");
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => false
            ]
        ];
    }
}
