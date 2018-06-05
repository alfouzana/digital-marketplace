<?php

namespace Tests\Feature\Vendor\NewProduct;

use App\File;
use App\Vendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewProductSampleStepTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_vendor_can_upload_the_new_product_sample_file()
    {
        Storage::fake('public');

        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->get('/vendor/new-product/sample')
            ->assertSee(__('New Product'))
            ->assertSee(__('Sample'));

        $this->post('/vendor/new-product/sample', [
            'sample' => UploadedFile::fake()->create('sample')
        ])->assertRedirect('/vendor/new-product/file')
        ->assertSessionHas('new_product.sample_step.sample_id');

        $sampleId = session('new_product.sample_step.sample_id');

        $this->assertDatabaseHas('files', [
            'id' => $sampleId,
            'assoc' => 'sample',
            'product_id' => null
        ]);

        $sample = File::find($sampleId);

        Storage::disk('public')->assertExists($sample->path);
    }

    /**
     * @test
     */
    public function a_non_authenticated_user_may_not_upload_the_new_product_sample()
    {
        $this->withExceptionHandling();

        $this->get('/vendor/new-product/sample')
            ->assertRedirect('/login');

        $this->post('/vendor/new-product/sample')
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function a_non_vendor_user_may_not_upload_the_new_product_sample()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            $this->createNonVendorUser()
        );

        $this->get('/vendor/new-product/sample')
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->post('/vendor/new-product/sample')
            ->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertSessionMissing('new_product.sample_step');
    }

    /**
     * @test
     */
    public function a_vendor_user_should_enter_valid_data_for_cover_step()
    {
        $this->withExceptionHandling();

        $this->actingAs(
            factory(Vendor::class)->create()
        );

        $this->post('/vendor/new-product/sample', [
            'sample' => ''
        ], [
            'referer' => url('/vendor/new-product/sample')
        ])->assertRedirect('/vendor/new-product/sample')
        ->assertSessionHasErrors([
            'sample'
        ]);
    }
}