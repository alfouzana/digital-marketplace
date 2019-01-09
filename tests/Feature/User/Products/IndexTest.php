<?php

namespace Tests\Feature\User\Products;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_user_can_view_their_products_with_any_approval_status()
    {
        $user = factory(User::class)->create();

        $approvedProduct = create_approved_product([
            'user_id' => $user->id
        ]);

        $pendingProduct = create_pending_product([
            'user_id' => $user->id
        ]);

        $rejectedProduct = create_rejected_product([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $this->get('/user/products')
            ->assertSee($approvedProduct->title)
            ->assertSee($pendingProduct->title)
            ->assertSee($rejectedProduct->title);
    }

    /**
     * @test
     */
    public function a_user_does_not_see_others_products_in_their_products_index()
    {
        $user = factory(User::class)->create();

        $product = create_approved_product();

        $this->actingAs($user);

        $this->get('/user/products')
            ->assertDontSee($product->title);
    }
    
    /**
     * @test
     */
    public function a_user_can_request_to_view_their_archived_products()
    {
        $user = factory(User::class)->create();

        with($archivedProduct = factory(Product::class)->create([
            'user_id' => $user->id,
        ]))->delete();

        $notArchivedProduct = factory(Product::class)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $this->get('/user/products')
            ->assertDontSee($archivedProduct->title);

        $this->get('/user/products?archived')
            ->assertSee($archivedProduct->title)
            ->assertDontSee($notArchivedProduct->title);
    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_access_to_the_user_products_index()
    {
        $this->withExceptionHandling();

        $this->get('/user/products')
            ->assertRedirect('/login');
    }           

    /**
     * @test
     */
    public function an_admin_user_cannot_access_to_the_user_products_index()
    {
        $admin = factory(User::class)
            ->states('admin')->create();

        $this->actingAs($admin);

        $this->get('/user/products')
            ->assertRedirect('/admin');
    }
}
