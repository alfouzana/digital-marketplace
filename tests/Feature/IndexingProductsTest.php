<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
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
        $product = create_approved_product();

        $this->get('products')
            ->assertSee($product->title);
    }

    /**
     * @test
     */
    public function a_user_can_not_view_non_approved_products()
    {
        $pendingProduct = create_pending_product();
        $rejectedProduct = create_rejected_product();

        $this->get('/products')
            ->assertDontSee($pendingProduct->title)
            ->assertDontSee($rejectedProduct->title);
    }

    /**
     * @test
     */
    public function a_user_can_not_view_archived_products()
    {
        $product = create_approved_product();
        $product->delete();

        $this->get('products')
            ->assertDontSee($product->title);
    }

    /**
     * @test
     */
    public function a_user_can_filter_products_by_category()
    {
        $category = factory(Category::class)->create();

        $productFromCategory = create_approved_product([
            'category_id' => $category->id
        ]);

        $productNotFromCategory = create_approved_product();

        $this->get($category->url())
            ->assertSee($productFromCategory->title)
            ->assertDontSee($productNotFromCategory->title);
    }
}
