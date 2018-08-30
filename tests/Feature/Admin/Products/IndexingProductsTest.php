<?php

namespace Tests\Feature\Admin\Products;

use App\Admin;
use App\Product;
use Mtvs\EloquentApproval\ApprovalStatuses;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexingProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_admin_user_can_view_the_list_of_products()
    {
        $products[] = factory(Product::class)->create();

        $products[] = factory(Product::class)->create([
            'approval_status' => ApprovalStatuses::APPROVED
        ]);

        $products[] = factory(Product::class)->create([
            'approval_status' => ApprovalStatuses::REJECTED
        ]);

        $this->actingAs(
            factory(Admin::class)->create()
        );

        $response = $this->get('admin/products');

        foreach ($products as $product) {
            $response->assertSee($product->title);
        }
    }
}
