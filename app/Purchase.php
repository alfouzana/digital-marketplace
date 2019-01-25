<?php

namespace App;

use App\Presenters\PurchasePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use Hashids;

class Purchase extends Model implements HasPresenter
{
    const UPDATED_AT = null;

    public function hashId()
    {
        return Hashids::connection('purchases')->encode($this->id);
    }

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
