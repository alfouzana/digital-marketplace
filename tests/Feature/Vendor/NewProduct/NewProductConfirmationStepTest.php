<?php

namespace Tests\Feature\Vendor\NewProduct;

use App\File;
use App\Product;
use App\Vendor;
use Illuminate\Support\Str;
use Mtvs\EloquentApproval\ApprovalStatuses;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewProductConfirmationStepTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_vendor_can_confirm_a_new_product_data_and_create_it()
    {
        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->session([
            'new_product' => [
                'details_step' => $productDetails = array_except(
                    factory(Product::class)->raw(),
                    'user_id'
                ),
                'cover_step' => [
                    'file_id' => $productCoverId = factory(File::class, 'cover')->create()->id
                ],
                'sample_step' => [
                    'file_id' => $productSampleId = factory(File::class, 'sample')->create()->id
                ],
                'product_file_step' => [
                    'file_id' => $productFileId = factory(File::class, 'product_file')->create()->id
                ]
            ]
        ]);

        $this->get('/vendor/new-product/confirmation')
            ->assertSee(__('New Product'))
            ->assertSee(__('Confirmation'));

        $postTime = (new Product())->freshTimestampString();
        $this->post('/vendor/new-product/confirmation')
            ->assertRedirect('/vendor/products')
            ->assertSessionMissing('new_product');

        $this->assertDatabaseHas('products', $productData = array_merge(
            $productDetails, [
            'slug' => Str::slug($productDetails['title']),
            'user_id' => auth()->id(),
            'approval_status' => ApprovalStatuses::PENDING,
            'created_at' => $postTime,
            'updated_at' => $postTime
        ]));

        $productId = (new Product)->newQueryWithoutScopes()
            ->where($productData)->first()->id;

        foreach ([$productCoverId, $productSampleId, $productFileId] as $fileId) {
            $this->assertDatabaseHas('files', [
                'id' => $fileId,
                'product_id' => $productId
            ]);
        }
    }
}
