<?php

namespace App\Http\Controllers\User;

use App\Enums\UserTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Product;
use App\Category;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()
            ->products()
            ->anyApprovalStatus();

        if ($request->has('archived')) {
            $query->onlyTrashed();
        }

        $products = $query->latest('updated_at')->paginate();

        return view('user.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        $category_options = $categories->pluck('id')
            ->combine(
                $categories->pluck('name')
            )->all();

        $category_options = ['' => __('Please select one')] + $category_options;

        return view('user.products.create', compact('category_options'));
    }

    public function store(Request $request)
    {
        // todo: Validate the request
        
        $data = array_merge($request->only([
            'cover_id', 'sample_id', 'file_id',
            'category_id', 'title', 'body', 'price'
        ]), [
            'user_id' => auth()->id(),
        ]);

        Product::create($data);

        return redirect('/user/products');
    }
}
