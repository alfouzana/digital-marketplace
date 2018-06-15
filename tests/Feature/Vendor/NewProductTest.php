<?php

namespace Tests\Feature\Vendor;

use App\File;
use App\Product;
use App\Vendor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mtvs\EloquentApproval\ApprovalStatuses;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_non_authenticated_user_may_not_access_new_product_steps()
    {
        $this->withExceptionHandling();

        $this->get('/vendor/new-product/details')
            ->assertRedirect('/login');
        $this->post('/vendor/new-product/details')
            ->assertRedirect('/login');

        $this->get('/vendor/new-product/cover')
            ->assertRedirect('/login');
        $this->post('/vendor/new-product/cover')
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function a_non_vendor_user_may_not_access_new_product_steps()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            $this->createNonVendorUser()
        );

        $this->get('/vendor/new-product/details')
            ->assertStatus(403);
        $this->post('/vendor/new-product/details')
            ->assertStatus(403);

        $this->get('/vendor/new-product/cover')
            ->assertStatus(403);
        $this->post('/vendor/new-product/cover')
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

    /**
     * @test
     */
    public function a_vendor_user_should_have_passed_the_new_product_details_before_the_cover()
    {
        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->get('/vendor/new-product/cover')
            ->assertRedirect('/vendor/new-product');
        $this->post('/vendor/new-product/cover')
            ->assertRedirect('/vendor/new-product');
    }

    /**
     * @test
     */
    public function a_vendor_user_can_upload_the_new_product_cover()
    {
        Storage::fake('public');

        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $details = factory(Product::class, 'details')->raw();
        $this->post('/vendor/new-product/details', $details);

        $this->post('/vendor/new-product/cover', [
            'cover' => UploadedFile::fake()->image('cover.jpg', 640, 480)
        ])->assertSessionHas('new_product.cover_step.file_id')
            ->assertRedirect('/vendor/new-product/sample');

        $cover_id = session('new_product.cover_step.file_id');

        $this->assertDatabaseHas('files', [
            'id' => $cover_id,
            'assoc' => 'cover',
            'product_id' => null
        ]);

        $cover = File::find($cover_id);

        Storage::disk('public')->assertExists($cover->path);
    }

    /**
     * @test
     */
    public function a_vendor_user_should_enter_valid_data_into_the_new_product_cover()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $details = factory(Product::class, 'details')->raw();
        $this->post('/vendor/new-product/details', $details);

        // missing cover
        $this->post('/vendor/new-product/cover', [

        ], [
            'referer' => url('/vendor/new-product/cover')
        ])->assertSessionHasErrors([
                'cover'
        ])->assertRedirect('/vendor/new-product/cover');

        // not a file
        $this->post('/vendor/new-product/cover', [
            'cover' => 'not a file'
        ], [
            'referer' => url('/vendor/new-product/cover')
        ])->assertSessionHasErrors([
            'cover'
        ])->assertRedirect('/vendor/new-product/cover');

        // not an image
        $this->post('/vendor/new-product/cover', [
            'cover' => UploadedFile::fake()->create('file.txt')
        ], [
            'referer' => url('/vendor/new-product/cover')
        ])->assertSessionHasErrors([
            'cover'
        ])->assertRedirect('/vendor/new-product/cover');

        // invalid dimensions
        $this->post('/vendor/new-product/cover', [
            'cover' => UploadedFile::fake()->image('cover.jpg')
        ], [
            'referer' => url('/vendor/new-product/cover')
        ])->assertSessionHasErrors([
            'cover'
        ])->assertRedirect('/vendor/new-product/cover');
    }
}
