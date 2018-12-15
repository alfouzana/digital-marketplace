<?php

namespace Tests\Feature\Purchase;

use App\Customer;
use App\Product;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexPurchasesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_customer_can_index_their_purchased_products()
    {
        $customer = factory(Customer::class)->create();

        $products = create_approved_product([], 4);

        foreach ($products as $product) {
            create_product_files($product->id);
        }

        foreach ($products as  $product) {
            $customer->makePurchase($product);
        }

        $products[1]->delete();
        $products[2]->suspend();
        $products[3]->reject();

        $this->actingAs($customer);

        $response = $this->get('customer/purchases');

        $response->assertSee($products[0]->title);
        $response->assertSee($products[1]->title);
        $response->assertDontSee($products[2]->title);
        $response->assertDontSee($products[3]->title);
    }

    /**
     * @test
     */
    public function an_unauthenticated_user_can_not_visit_the_customer_purchases_page()
    {
        $this->withExceptionHandling();

        $this->get('customer/purchases')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_non_customer_user_can_not_visit_the_customer_purchases_page()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            $this->createNonCustomerUser()
        );

        $this->get('customer/purchases')->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
