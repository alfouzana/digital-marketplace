<?php

namespace Tests\Feature\Vendor;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexingProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_non_vendor_user_may_not_view_vendor_products()
    {
        $this->withExceptionHandling();

        // unauthenticated attempt
        $this->get('/vendor/products')
            ->assertRedirect('/login');

        // non vendor attempt
        $this->actingAs(
            $this->createNonVendorUser()
        );
        $this->get('/vendor/products')
            ->assertStatus(403);
    }

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
    public function a_vendor_may_not_view_products_not_belong_to_them()
    {
        $vendorUser = factory(Vendor::class)->create();

        $notBelongingProduct = factory(Product::class)->create();

        $this->signIn($vendorUser);

        $this->get('/vendor/products')
            ->assertDontSee($notBelongingProduct->title);
    }
    
    /**
     * @test
     */
    public function a_vendor_can_request_to_view_their_archived_products()
    {
        $vendorUser = factory(Vendor::class)->create();

        with($archivedProduct = factory(Product::class)->create([
            'user_id' => $vendorUser->id,
        ]))->delete();

        $notArchivedProduct = factory(Product::class)->create([
            'user_id' => $vendorUser->id,
        ]);

        $this->signIn($vendorUser);

        $this->get('/vendor/products')
            ->assertDontSee($archivedProduct->title);

        $this->get('/vendor/products?archived')
            ->assertSee($archivedProduct->title)
            ->assertDontSee($notArchivedProduct->title);
    }
}
