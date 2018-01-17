<?php

namespace Tests\Feature\Vendor;

use App\Admin;
use App\Customer;
use App\Product;
use App\Vendor;
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

        $adminUser = factory(Admin::class)->create();
        $customerUser = factory(Customer::class)->create();

        $path = '/vendor/products';

        // unauthenticated
        $this->get($path)
            ->assertRedirect('/login');

        // Admin user
        $this->signIn($adminUser);
        $this->get($path)
            ->assertStatus(403);

        // Customer user
        $this->signIn($customerUser);
        $this->get($path)
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_vendor_can_view_their_products_with_any_approval_status()
    {
        $vendorUser = factory(Vendor::class)->create();

        $approvedProduct = create_approved_product([
            'user_id' => $vendorUser->id
        ]);

        $pendingProduct = create_pending_product([
            'user_id' => $vendorUser->id
        ]);

        $rejectedProduct = create_rejected_product([
            'user_id' => $vendorUser->id
        ]);

        $this->signIn($vendorUser);

        $this->get('/vendor/products')
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
