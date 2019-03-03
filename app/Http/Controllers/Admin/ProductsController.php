<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mtvs\EloquentApproval\ApprovalStatuses;
use App\Http\Resources\ProductResource;
use App\Presenters\ProductPresenter;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::anyApprovalStatus()
            ->when($request->filled('approval_status'), function (Builder $query) use ($request) {
                $query->where('approval_status', $request['approval_status']);
            })
            ->paginate();

        return view('admin.products.index', compact('products'));
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

        $presenter = new ProductPresenter($product);

        return response()->json([
            'approval_status' => $presenter->approval_status,
            'approval_context' => $presenter->approval_context,
            'updated_at' => $presenter->updated_at,
            'approval_at' => $presenter->approval_at,
        ]);
    }
}
