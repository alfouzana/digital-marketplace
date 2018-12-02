<?php

namespace App\Http\Controllers\Customer;

use App\Product;
use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Charge;
use Vinkla\Hashids\Facades\Hashids;

class PurchasesController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::find(
            @Hashids::decode($request['product'])[0]
        );

        if (! $product) {
            return redirect('/');
        }

        // todo: Improve product price conversion to stripe amount
        // todo: Supprot different currencies
        // todo: Consider max limit of stripe amount
        Charge::create([
            'amount' => $product->price * 100,
            'currency' => 'usd',
            'description' => sprintf('Purchase at "%s"', config('app.name')) ,
            'source' => $request['stripeToken'],
        ]);

        // todo: do error handling for stripe api

        auth()->user()->purchasedProducts()->attach($product->id, [
            'amount' => $product->price,
            'created_at' => now(),
        ]);

    }
}
