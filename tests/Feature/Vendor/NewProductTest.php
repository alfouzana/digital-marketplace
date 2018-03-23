<?php

namespace Tests\Feature\Vendor;

use App\Product;
use App\Vendor;
use Mtvs\EloquentApproval\ApprovalStatuses;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_non_authenticated_user_may_not_enter_new_product_details()
    {
        $this->withExceptionHandling();

        $this->get('/vendor/new-product/details')
            ->assertRedirect('/login');

        $this->post('/vendor/new-product/details')
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function a_non_vendor_user_may_not_enter_new_product_details()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            $this->createNonVendorUser()
        );

        $this->get('/vendor/new-product/details')
            ->assertStatus(403);

        $this->post('/vendor/new-product/details')
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_vendor_user_can_enter_new_product_details()
    {
        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->get('/vendor/new-product/details')
            ->assertSee(__('New Product'))
            ->assertSee(__('Details'));

        $data = factory(Product::class, 'details')->raw();

        $this->post('/vendor/new-product/details', $data)
            ->assertRedirect('/vendor/new-product/cover')
            ->assertSessionHas('new_product.details_step.title', $data['title']);
    }

    /**
     * @test
     */
    public function a_vendor_user_can_not_enter_non_allowed_data_into_new_product_details()
    {
        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $data = factory(Product::class, 'details')->raw();
        $data['approval_status'] = ApprovalStatuses::APPROVED;

        $this->post('/vendor/new-product/details', $data)
            ->assertRedirect('/vendor/new-product/cover')
            ->assertSessionHas('new_product.details_step.title', $data['title'])
            ->assertSessionMissing('new_product.details_step.approval_status');
    }

    /**
     * @test
     */
    public function a_vendor_user_should_enter_validated_data_into_new_product_details()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->post('/vendor/new-product/details', [
            'title' => '',
            'body' => '',
            'price' => '',
            'category_id' => '',
        ])->assertSessionHasErrors([
            'title',
            'body',
            'price',
            'category_id'
        ]);

        $this->post('/vendor/new-product/details', [
            'price' => 'some price',
            'category_id' => '123',
        ])->assertSessionHasErrors([
            'price',
            'category_id'
        ]);

        $this->post('/vendor/new-product/details', [
            'price' => '-1'
        ])->assertSessionHasErrors([
            'price'
        ]);
    }
}
