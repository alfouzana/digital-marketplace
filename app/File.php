<?php

namespace App;

use App\Presenters\FilePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Model implements HasPresenter
{
    protected $guarded = [];

    public static function createFromUploadedFile(UploadedFile $file, $attributes = [])
    {
        $attributes = array_merge([
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize()
        ], $attributes);

        return static::create($attributes);
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
