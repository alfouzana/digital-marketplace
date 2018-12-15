<?php

namespace App;

use App\Presenters\PurchasePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Purchase extends Model implements HasPresenter
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return PurchasePresenter::class;
    }
}
