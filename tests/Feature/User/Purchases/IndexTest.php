<?php

namespace Tests\Feature\User\Purchases;

use App\User;
use App\Purchase;
use App\Product;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_index_their_purchases()
    {
        $user = factory(User::class)->create();

        $purchases = factory(Purchase::class, 5)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('user/purchases');

        foreach ($purchases as $purchase) {
            $response->assertSee($purchase->hashId());
        }
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
