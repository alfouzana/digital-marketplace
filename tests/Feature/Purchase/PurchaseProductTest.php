<?php

namespace Tests\Feature\Purchase;

use App\Customer;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Vinkla\Hashids\Facades\Hashids;

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

        $response = $this->post('customer/purchases?product='.Hashids::encode($product->id), [
            'stripeToken' => 'tok_visa'
        ]);

        $response->assertRedirect('customer/purchases');

        $this->assertDatabaseHas('purchases', [
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'amount' => $product->price,
            'created_at' => now(),
        ]);
    }

    /**
     * @test
     */
    public function a_customer_can_not_purchase_a_product_that_is_not_available()
    {
        $this->actingAs(
            factory(Customer::class)->create()
        );

        $this->post('customer/purchases', [
            'stripeToken' => 'tok_visa'
        ])->assertRedirect('/');

        $this->post('customer/purchases?product='.Hashids::encode('123'), [
            'stripeToken' => 'tok_visa'
        ], [
            'referer' => url('product_uri')
        ])->assertRedirect('/');

        $product = create_pending_product();
        $this->post('customer/purchases?product='.Hashids::encode($product->id), [
            'stripeToken' => 'tok_visa'
        ], [
            'referer' => $product->url()
        ])->assertRedirect('/');

        $product = create_rejected_product();
        $this->post('customer/purchases?product='.Hashids::encode($product->id), [
            'stripeToken' => 'tok_visa'
        ], [
            'referer' => $product->url()
        ])->assertRedirect('/');

        with($product = create_approved_product())->delete();
        $this->post('customer/purchases?product='.Hashids::encode($product->id), [
            'stripeToken' => 'tok_visa'
        ], [
            'referer' => $product->url()
        ])->assertRedirect('/');
    }

    /**
     * @test
     */
    public function a_customer_can_not_purchase_a_product_multiple_times()
    {
        $product = create_approved_product();

        $customer = factory(Customer::class)->create();

        $customer->purchasedProducts()->attach($product->id, [
            'amount' => $product->price,
            'created_at' => now(),
        ]);

        $this->actingAs($customer);

        $response = $this->post('customer/purchases?product='.Hashids::encode($product->id), [
            'stripeToken' => 'tok_visa'
        ]);

        $response->assertRedirect($product->url());
    }
}
