<?php

namespace App\Presenters;

use App\Purchase;
use McCool\LaravelAutoPresenter\BasePresenter;

class PurchasePresenter extends BasePresenter
{

    /**
     * PurchasePresenter constructor.
     * @param Purchase $resource
     */
    public function __construct(Purchase $resource)
    {
        $this->wrappedObject = $resource;
    }

    public function created_at()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    public function amount()
    {
        return number_format($this->wrappedObject->amount, 2);
    }
}