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
    public function store(Request $request)
    {
        $product = Product::find(
            @Hashids::decode($request['product'])[0]
        );

        if (! $product) {
            return redirect('/');
        }

        if (auth()->user()->hasPurchased($product)) {
            flash(__('Already has been purchased!'))->error();

            return redirect($product->url());
        }

        DB::beginTransaction();

        try {
            // First we attempt to add the product the customer purchases
            // so if any problem occurs in this process we haven't charged
            // the customer yet
            auth()->user()->makePurchase($product);

            // todo: Consider max limit of stripe amount
            StripeCharge::create([
                'amount' => $product->price * 100,
                'currency' => 'usd',
                'description' => sprintf('Purchase at "%s"', config('app.name')) ,
                'source' => $request['stripeToken'],
            ]);
        } catch (\Exception $exception) {
            DB::rollback();

            if ($exception instanceof StripCardException) {
                $message = $exception->getJsonBody()['error']['message'];

                flash($message)->error();

                return back();
            }

            throw $exception;
        }

        DB::commit();

        return redirect('customer/purchases');
    }
}
