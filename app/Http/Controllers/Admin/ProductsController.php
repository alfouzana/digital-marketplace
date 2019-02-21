<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mtvs\EloquentApproval\ApprovalStatuses;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::anyApprovalStatus()
            ->when(\request()->filled('approval_status'), function (Builder $query) {
                $query->where('approval_status', \request()->input('approval_status'));
            })
            ->paginate();

        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        // todo: Fail when not found
        $product = Product::anyApprovalStatus()->find($id);

        return response()->json($product);
    }

    public function approval($id, Request $request)
    {
    	// todo: fail when not found
    	$product = Product::anyApprovalStatus()->find($id);


    	// todo: validata status 
    	if ($request['status'] == ApprovalStatuses::PENDING) {
    		$product->suspend();
    	}
    	elseif ($request['status'] == ApprovalStatuses::APPROVED) {
    		$product->approve();
    	}
    	else {
    		$product->reject();
    	}
    }
}
