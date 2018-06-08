<?php

namespace Tests\Feature\Vendor\NewProduct;

use App\File;
use App\Vendor;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
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
        Storage::fake('local');

        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->get('/vendor/new-product/product-file')
            ->assertSee(__('New Product'))
            ->assertSee(__('Product File'));

        $this->post('/vendor/new-product/product-file', [
            'file' => UploadedFile::fake()->create('file')
        ])->assertRedirect('/vendor/new-product/confirm')
            ->assertSessionHas('new_product.product_file_step.file_id');

        $file_id = session('new_product.product_file_step.file_id');

        $this->assertDatabaseHas('files', [
            'id' => $file_id,
            'assoc' => 'product',
            'product_id' => null
        ]);

        $file = File::find($file_id);

        Storage::disk('local')->assertExists($file->path);
    }

    /**
     * @test
     */
    public function a_vendor_user_should_enter_valid_data_for_the_new_product_file_step()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->post('/vendor/new-product/product-file', [
            'file' => ''
        ], [
            'referer' => '/vendor/new-product/product-file'
        ])->assertSessionHasErrors('file')
            ->assertRedirect('/vendor/new-product/product-file');
    }

    /**
     * @test
     */
    public function a_non_authenticated_user_may_not_upload_the_new_product_file()
    {
        $this->withExceptionHandling();

        $this->get('/vendor/new-product/product-file')
            ->assertRedirect('/login');

        $this->post('/vendor/new-product/product-file')
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function a_non_vendor_user_may_not_upload_the_new_product_file()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            $this->createNonVendorUser()
        );

        $this->get('/vendor/new-product/product-file')
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->post('/vendor/new-product/product-file')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
