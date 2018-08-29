<?php

namespace App\Http\Controllers\Vendor\NewProduct;


use App\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DownloadProductFileController extends Controller
{
    public function index()
    {
        $file = File::findOrFail(session('new_product.product_file_step.file_id'));

        return response(Storage::disk($file->disk)->get($file->path), 200, [
                'Content-Disposition' => 'attachment; filename='.$file->original_name
            ]
        );
    }
}