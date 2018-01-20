<?php

namespace App\Presenters;

use App\Product;
use Illuminate\Support\HtmlString;
use McCool\LaravelAutoPresenter\BasePresenter;

class ProductPresenter extends BasePresenter
{

    /**
     * ProductPresenter constructor.
     * @param Product $resource
     */
    public function __construct(Product $resource)
    {
        $this->wrappedObject = $resource;
    }

    public function cover_url()
    {
        return asset($this->wrappedObject->cover_path);
    }

    public function sample_url()
    {
        return asset($this->wrappedObject->sample_path);
    }

    public function body()
    {
        return new HtmlString(
            nl2br(
                e($this->wrappedObject->body)
            )
        );
    }

    public function price()
    {
        return number_format($this->wrappedObject->price, 2);
    }

    public function created_at()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    public function updated_at()
    {
        return $this->wrappedObject->updated_at->diffForHumans();
    }

    public function approval_lang()
    {
        return approval_lang($this->wrappedObject->approval_status);
    }

    public function approval_context()
    {
        return approval_context($this->wrappedObject->approval_status);
    }

    public function showable()
    {
        return $this->wrappedObject->isApproved() && ! $this->wrappedObject->trashed();
    }
}