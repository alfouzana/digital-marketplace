<?php

namespace App\Http\Controllers\Customer;

use App\Product;
use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Stripe\Charge as StripeCharge;
use Stripe\Error\Card as StripCardException;
use Vinkla\Hashids\Facades\Hashids;

class PurchasesController extends Controller
{
    public function index()
    {
        $purchases = auth()->user()->purchases()
            ->with([
                'product' => function ($query) {
                    $query->withoutGlobalScopes();
                }
            ])
            ->latest('created_at')
            ->paginate();

        return view('customer.purchases.index', compact('purchases'));
    }

    public function store(Request $request)
    {
        $product = Product::find(
            @Hashids::decode($request['product'])[0]
        );

        if (! $product) {
            return redirect('/');
        }

        if (auth()->user()->hasPurchased($product)) {
            flash(__('You\'ve already purchased this product!'))->error();

            return redirect($product->url());
        }

        auth()->user()->makePurchase($product);

        flash('Purchase done successfully.')->success();

        return redirect('customer/purchases');
    }
}
