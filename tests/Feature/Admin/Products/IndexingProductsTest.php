<?php

namespace Tests\Feature\Admin\Products;

use App\Admin;
use App\Product;
use Illuminate\Http\Response;
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

    /**
     * @test
     */
    public function an_admin_user_can_filter_the_index_of_products_for_a_specific_approval_status()
    {
        $approvalStatuses = [
            ApprovalStatuses::PENDING,
            ApprovalStatuses::APPROVED,
            ApprovalStatuses::REJECTED,
        ];

        foreach ($approvalStatuses as $approvalStatus) {
            factory(Product::class)->create([
                'approval_status' => $approvalStatus
            ]);
        }

        $this->actingAs(
            factory(Admin::class)->create()
        );

        foreach ($approvalStatuses as $approvalStatus) {
            $response = $this->get('admin/products?approval_status='.$approvalStatus);

            $productsWithTheApprovalStatus = Product::anyApprovalStatus()
                ->where('approval_status', $approvalStatus)->get();

            foreach ($productsWithTheApprovalStatus as $product) {
                $response->assertSee($product->title);
            }

            $productsWithoutTheApprovalStatus = Product::anyApprovalStatus()
                ->where('approval_status', '!=', $approvalStatus)->get();

            foreach ($productsWithoutTheApprovalStatus as $product) {
                $response->assertDontSee($product->title);
            }
        }
    }

    /**
     * @test
     */
    public function an_unauthenticated_user_can_not_visit_the_products_index_for_the_admin_panel()
    {
        $this->withExceptionHandling();

        $this->get('admin/products')
            ->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_non_admin_user_can_not_visit_the_products_index_for_the_admin_panel()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            $this->createNonAdminUser()
        );

        $this->get('admin/products')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
