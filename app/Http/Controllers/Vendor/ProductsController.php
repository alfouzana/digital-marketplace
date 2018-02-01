<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\UserTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user();

        $query = $vendor->products()->anyApprovalStatus();

        if ($request->has('archived')) {
            $query->onlyTrashed();
        }

        $products = $query->paginate();

        return view('vendor.products.index', compact('products'));
    }
}
