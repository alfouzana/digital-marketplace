<?php

namespace App\Http\Controllers\Vendor;

use App\Category;
use App\File;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Support\Facades\Storage;

class NewProductController extends Controller
{
    public function showDetailsStep()
    {
        return view('vendor.new-product.details-step');
    }
    public function processDetailsStep(Request $request)
    {
        $this->validate($request, [
            'title' => 'required', // todo: specify min and max for product title
            'body' => 'required',
            'price' => 'required|numeric|min:0', // todo: specify min and max for product price
            'category_id' => 'required|exists:categories,id'
        ]);

        session()->put('new_product.details_step', $request->only([
            'title',
            'body',
            'price',
            'category_id'
        ]));

        return redirect('/vendor/new-product/cover');
    }

    public function showCoverStep()
    {
        if (! session()->has('new_product.details_step'))
        {
            return redirect('/vendor/new-product/');
        }

        return view('vendor.new-product.cover-step');
    }

    public function processCoverStep(Request $request)
    {
        // todo: If should be done should be consistent in other methods too
        if (! session()->has('new_product.details_step'))
        {
            return redirect('/vendor/new-product');
        }

        $this->validate($request, [
            'cover' => 'required|file|mimes:jpeg|dimensions:min_width=640,ratio=4/3'
        ]);

        // todo: resize every uploaded cover to a fix size

        $cover = $this->storeTheUploadedFileAndCreateTheModel(
            $request->file('cover'), 'public', 'product_covers', 'cover'
        );

        session()->put('new_product.cover_step.file_id', $cover->id);

        return redirect('/vendor/new-product/sample');
    }

    public function showSampleStep()
    {
        return view('vendor.new-product.sample-step');
    }

    public function processSampleStep(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file'
        ]);

        $file = $this->storeTheUploadedFileAndCreateTheModel(
            $request->file('file'), 'public', 'product_samples', 'sample'
        );

        session()->put('new_product.sample_step.file_id', $file->id);

        return redirect('/vendor/new-product/product-file');
    }

    public function showProductFileStep()
    {
        return view('vendor.new-product.product-file-step');
    }

    public function processProductFileStep(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file'
        ]);

        $file = $this->storeTheUploadedFileAndCreateTheModel(
            $request->file('file'), 'local', 'product_files', 'product'
        );

        session()->put('new_product.product_file_step.file_id', $file->id);

        return redirect('/vendor/new-product/confirmation');
    }

    public function showConfirmationStep()
    {
        $product_data['title'] = session('new_product.details_step.title');
        $product_data['body'] = session('new_product.details_step.body');
        $product_data['price'] = session('new_product.details_step.price');

        $category = Category::find(session('new_product.details_step.category_id'));

        $cover = File::find(session('new_product.cover_step.file_id'));
        $sample = File::find(session('new_product.sample_step.file_id'));
        $file = File::find(session('new_product.product_file_step.file_id'));

        return view('vendor.new-product.confirmation-step', compact(
            'product_data',
            'category',
            'cover',
            'sample',
            'file'
        ));
    }

    public function processConfirmationStep()
    {
        DB::transaction(function () {
            $product = auth()->user()->products()->create(
                session('new_product.details_step')
            );

            // consider failing the process if a file not found
            $files = File::find([
                session('new_product.cover_step.file_id'),
                session('new_product.sample_step.file_id'),
                session('new_product.product_file_step.file_id'),
            ]);

            foreach ($files as $file) {
                $file->update([
                    'product_id' => $product->id
                ]);
            }
        });

        session()->remove('new_product');

        return redirect('/vendor/products');
    }

    private function storeTheUploadedFileAndCreateTheModel(UploadedFile $file, $disk, $dirPath, $assoc)
    {
        $path = $file->store($dirPath, $disk);

        return File::createFromUploadedFile($file, [
            'disk' => $disk,
            'path' => $path,
            'assoc' => $assoc,
        ]);
    }
}
