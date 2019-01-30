<?php

namespace App\Http\Controllers\User;

use App\Enums\UserTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Product;

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

    public function store(Request $request)
    {
        // todo: Validate the request
        
        $data = array_merge($request->only([
            'category_id', 'title', 'body', 'price'
        ]), [
            'user_id' => auth()->id(),
        ]);

        Product::create($data);

        return redirect('/user/products');
    }
}
