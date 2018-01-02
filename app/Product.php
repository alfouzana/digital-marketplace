<?php

namespace App;

use App\Presenters\ProductPresenter;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use McCool\LaravelAutoPresenter\HasPresenter;
use Mtvs\EloquentApproval\Approvable;
use Vinkla\Hashids\Facades\Hashids;

class Product extends Model implements HasPresenter
{
    use Sluggable, Approvable, SoftDeletes;

    protected $with = [
        'category',
        'vendor',
    ];

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return ProductPresenter::class;
    }
}
