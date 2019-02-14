<?php

namespace App;

use App\Presenters\FilePresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use McCool\LaravelAutoPresenter\HasPresenter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Model implements HasPresenter
{
    const ASSOC_COVER = 'cover';
    const ASSOC_SAMPLE = 'sample';
    const ASSOC_PRODUCT = 'product';

    protected $guarded = [];

    public function url()
    {
        if ($this->assoc == 'product_file') {
            return null;
        }

        return Storage::disk($this->disk)
            ->url($this->path);
    }

    public function getContents()
    {
        return Storage::disk($this->disk)->get($this->path);
    }

    public function getExtension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

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
