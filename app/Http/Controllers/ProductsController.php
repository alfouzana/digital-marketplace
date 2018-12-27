<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Category;
use App\Product;
use Hashids;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Category $category)
    {
        $query = Product::query();

        if ($category->exists) {
            $query->where('category_id', $category->id);
        }

        $products = $query->paginate();

        return view('products.index', compact('products'));
    }

    public function show($slug, Product $product)
    {
        // product's slug is presented in the url but it is not its route key
        // in case of incorrect slug the request is redirected to the correct url
        if ($slug != $product->slug) {
            return redirect($product->url(), 301);
        }

        return view('products.show', compact('product'));
    }

    public function downloadFile($hashid)
    {
        $product = Product::withTrashed()->findOrFail(
            @Hashids::decode($hashid)[0]
        );

        if(
            ! auth()->user() instanceof Admin &&
            ! auth()->user()->hasPurchased($product)) {
            return redirect($product->url());
        }

        return response(
            $product->file->getContents(),
            200,
            [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment;filename='.
                    $product->slug.'.'.$product->file->getExtension()
            ]
        );
    }
}
