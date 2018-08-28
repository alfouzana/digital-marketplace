<?php

namespace App\Presenters;


use App\File;
use Illuminate\Support\Facades\Storage;
use McCool\LaravelAutoPresenter\BasePresenter;

class FilePresenter extends BasePresenter
{

    /**
     * FilePresenter constructor.
     */
    public function __construct(File $resource)
    {
        $this->wrappedObject = $resource;
    }
}