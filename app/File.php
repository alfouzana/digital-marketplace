<?php

namespace App;

use App\Presenters\FilePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class File extends Model implements HasPresenter
{
    protected $guarded = [];

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return FilePresenter::class;
    }
}
