<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $limit = 6;

        $latestProducts = Product::latest()->limit($limit)->get();

        return view('home', compact('latestProducts'));
    }
}
