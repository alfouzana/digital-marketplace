<?php

namespace App\Http\Controllers\Customer;

use App\Product;
use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        if ($this->currentUserHasAlreadyBoughtTheProduct($product)) {
            flash(__('Already has been purchased!'))->error();

            return redirect($product->url());
        }

        try {
            // todo: Improve product price conversion to stripe amount
            // todo: Supprot different currencies
            // todo: Consider max limit of stripe amount
            StripeCharge::create([
                'amount' => $product->price * 100,
                'currency' => 'usd',
                'description' => sprintf('Purchase at "%s"', config('app.name')) ,
                'source' => $request['stripeToken'],
            ]);
        } catch (StripCardException $exception) {
            $message = $exception->getJsonBody()['error']['message'];

            flash($message)->error();

            return back();
        }

        auth()->user()->purchasedProducts()->attach($product->id, [
            'amount' => $product->price,
            'created_at' => now(),
        ]);

        return redirect('customer/purchases');
    }

    protected function currentUserHasAlreadyBoughtTheProduct(Product $product): bool
    {
        return (bool) auth()->user()->purchasedProducts()
            ->where('products.id', $product->id)->count();
    }
}
