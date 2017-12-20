<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentApproval\Approvable;

class Product extends Model
{
    use Sluggable, Approvable, SoftDeletes;

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
