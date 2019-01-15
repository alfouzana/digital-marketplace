<?php

namespace App\Http\Controllers\User;

use App\Enums\UserTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
}
