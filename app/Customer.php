<?php

namespace App;

use App\Enums\UserTypes;

class Customer extends User
{
    protected static $singleTableType = UserTypes::CUSTOMER;

    public function purchasedProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'purchases',
            'user_id'
        );
    }

    public function makePurchase(Product $product): void
    {
        $this->purchasedProducts()->attach($product->id, [
            'amount' => $product->price,
            'created_at' => now(),
        ]);
    }

    public function hasPurchased(Product $product): bool
    {
        return (bool) $this->purchasedProducts()
            ->where('products.id', $product->id)->count();
    }
}
