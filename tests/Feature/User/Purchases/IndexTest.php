<?php

namespace Tests\Feature\User\Purchases;

use App\User;
use App\Purchase;
use App\Product;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mtvs\EloquentApproval\ApprovalStatuses;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_user_can_see_their_purchases()
    {
        $user = factory(User::class)->create();

        $purchases = factory(Purchase::class, 3)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/user/purchases');

        foreach ($purchases as $purchase) {
            $response->assertSee($purchase->hashId());
            $response->assertSee($purchase->product->title);
        }
    }

    /**
     * @test
     */
    public function an_user_cannot_access_their_purchased_products_that_are_not_approved_anymore()
    {
        $user = factory(User::class)->create();

        $purchases[] = factory(Purchase::class)->create([
            'user_id' => $user->id,
            'product_id' => with($products[] = factory(Product::class)->create([
                'approval_status' => ApprovalStatuses::PENDING,
            ]))->id
        ]);

        $purchases[] = factory(Purchase::class)->create([
            'user_id' => $user->id,
            'product_id' => with($products[] = factory(Product::class)->create([
                'approval_status' => ApprovalStatuses::REJECTED,
            ]))->id
        ]);

        $this->actingAs($user);

        
        foreach (range(0, 1) as $i) {
            $this->get('/user/purchases')
            ->assertSee($purchases[$i]->hashId())
            ->assertDontSee($products[$i]->title);
        }
    }

    /**
     * @test
     */
    public function an_user_can_see_their_purchased_products_that_have_been_archived()
    {
        $user = factory(User::class)->create();

        $purchase = factory(Purchase::class)->create([
            'user_id' => $user->id,
            'product_id' => with($product = factory(Product::class)->create([
                'approval_status' => ApprovalStatuses::APPROVED,
                'deleted_at' => now(),
            ]))->id
        ]);

        $this->actingAs($user);

        $this->get('/user/purchases')
            ->assertSee($purchase->hashId())
            ->assertSee($product->title);
    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_visit_the_user_purchases_page()
    {
        $this->withExceptionHandling();

        $this->get('/user/purchases')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function an_admin_cannot_visit_the_user_purchases_page()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            factory(User::class)->states('admin')->create()
        );

        $this->get('/user/purchases')->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
