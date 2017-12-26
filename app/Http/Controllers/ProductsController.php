<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate();

        return view('products.index', compact('products'));
    }

    public function show($slug, Product $product)
    {
        // product's slug is presented in the url but it is not its route key
        // in case of incorrect slug the request is redirected to the correct url
        if ($slug != $product->slug) {
            return redirect($product->url(), 301);
        }

        return $product;
    }
}
