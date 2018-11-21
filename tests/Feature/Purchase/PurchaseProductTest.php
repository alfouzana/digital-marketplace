<?php

namespace Tests\Feature\Purchase;

use App\Customer;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_customer_can_purchase_a_product()
    {
        $product = create_approved_product();

        $this->actingAs(
            factory(Customer::class)->create()
        );

        $this->post('customer/purchases/'.$product->getRouteKey(), [
            'stripeToken' => 'tok_visa'
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'amount' => $product->price,
            'created_at' => now(),
        ]);
    }
}
