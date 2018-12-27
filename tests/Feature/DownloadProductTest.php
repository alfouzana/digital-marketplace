<?php

namespace Tests\Feature;

use App\Admin;
use App\Customer;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownloadProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function a_product_purchaser_user_can_download_the_product_file()
    {
        Storage::fake();

        $product = create_approved_product();
        create_product_files($product->id);

        Storage::disk($product->file->disk)
            ->put($product->file->path, $this->faker->text);

        $user = factory(Customer::class)->create();

        $user->makePurchase($product);

        $this->actingAs($user);

        $this->get('product/'.$product->getRouteKey().'/file')
            ->assertSee($product->file->getContents())
            ->assertHeader(
                'content-disposition',
                'attachment;filename='.$product->slug.'.'.$product->file->getExtension()
            )
            ->assertHeader(
                'content-type',
                'application/octet-stream'
            );
    }

    /**
     * @test
     */
    public function a_non_product_purchaser_user_cannot_download_the_product_file()
    {
        Storage::fake();

        $product = create_approved_product();
        create_product_files($product->id);

        $user = factory(Customer::class)->create();

        $this->actingAs($user);

        $this->get('product/'.$product->getRouteKey().'/file')
            ->assertRedirect($product->url());
    }

    /**
     * @test
     */
    public function an_admin_user_can_download_the_file_of_any_product()
    {
        Storage::fake();

        $product = create_approved_product();
        create_product_files($product->id);
        Storage::disk($product->file->disk)
            ->put($product->file->path, $this->faker->text);

        $this->actingAs(
            factory(Admin::class)->create()
        );

        $this->get('product/'.$product->getRouteKey().'/file')
            ->assertSee($product->file->getContents())
            ->assertHeader(
                'content-disposition',
                'attachment;filename='.$product->slug.'.'.$product->file->getExtension()
            )
            ->assertHeader(
                'content-type',
                'application/octet-stream'
            );
    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_download_the_file_of_a_product()
    {
        $this->withExceptionHandling();

        Storage::fake();

        $product = create_approved_product();
        create_product_files($product->id);

        $this->get('product/'.$product->getRouteKey().'/file')
            ->assertRedirect('login');
    }

    /**
     * @test
     */
    public function it_is_still_possible_to_download_an_archived_product_file()
    {
        Storage::fake();

        $product = create_approved_product();
        create_product_files($product->id);
        Storage::disk($product->file->disk)
            ->put($product->file->path, $this->faker->text);

        $user = factory(Customer::class)->create();

        $user->makePurchase($product);

        $product->delete();

        $this->actingAs($user);

        $this->get('product/'.$product->getRouteKey().'/file')
            ->assertSee($product->file->getContents())
            ->assertHeader(
                'content-disposition',
                'attachment;filename='.$product->slug.'.'.$product->file->getExtension()
            )
            ->assertHeader(
                'content-type',
                'application/octet-stream'
            );
    }

    /**
     * @test
     */
    public function it_is_not_possible_to_download_a_non_approved_product_file()
    {
        $this->withExceptionHandling();

        Storage::fake();

        $product = create_approved_product();
        create_product_files($product->id);

        $user = factory(Customer::class)->create();

        $user->makePurchase($product);

        $product->reject();

        $this->actingAs($user);

        $this->get('product/'.$product->getRouteKey().'/file')
            ->assertStatus(404);

        $product->suspend();

        $this->get('product/'.$product->getRouteKey().'/file')
            ->assertStatus(404);
    }
}
