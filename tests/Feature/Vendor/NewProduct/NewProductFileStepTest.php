<?php

namespace Tests\Feature\Vendor\NewProduct;

use App\Vendor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class NewProductFileStepTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_vendor_can_upload_the_new_product_file()
    {
        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->get('/vendor/new-product/product-file')
            ->assertSee(__('New Product'))
            ->assertSee(__('Product File'));
    }
}
