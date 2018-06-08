<?php

namespace App\Http\Controllers\Vendor;

use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;

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
        if (! session()->has('new_product.details_step'))
        {
            return redirect('/vendor/new-product');
        }

        $this->validate($request, [
            'cover' => 'required|file|mimes:jpeg|dimensions:min_width=640,min_height=480,ratio=4/3'
        ]);

        $path = $request->file('cover')->store('product_covers', 'public');

        $cover = File::create([
            'path' => $path,
            'assoc' => 'cover',
        ]);

        session()->put('new_product.cover_step.cover_id', $cover->id);

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

        $path = $request->file('file')->store('product_samples', 'public');

        $file = File::create([
            'assoc' => 'sample',
            'path' => $path
        ]);

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

        $path = $request->file('file')->store('product_files', 'local');

        $file = File::create([
            'assoc' => 'product',
            'path' => $path
        ]);

        session()->put('new_product.product_file_step.file_id', $file->id);

        return redirect('/vendor/new-product/confirm');
    }
}
