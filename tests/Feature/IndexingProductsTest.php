<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexingProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    function a_user_can_view_products()
    {
        $product = $this->createApprovedProduct();

        $this->get('products')
            ->assertSee($product->title);
    }

    /**
     * @test
     */
    public function a_user_can_not_view_non_approved_products()
    {
        $pendingProduct = $this->createPendingProduct();
        $rejectedProduct = $this->createRejectedProduct();

        $this->get('/products')
            ->assertDontSee($pendingProduct->title)
            ->assertDontSee($rejectedProduct->title);
    }

    /**
     * @test
     */
    public function a_user_can_not_view_archived_products()
    {
        $product = $this->createApprovedProduct();
        $product->delete();

        $this->get('products')
            ->assertDontSee($product->title);
    }
}
