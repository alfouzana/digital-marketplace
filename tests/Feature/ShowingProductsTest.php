<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowingProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    function a_user_can_view_a_product()
    {
        $product = $this->createApprovedProduct();

        $this->get($product->url())
            ->assertSee($product->title);
    }

    /**
     * @test
     */
    public function a_user_is_redirected_when_uses_an_incorrect_slug_to_view_a_product()
    {
        $product = $this->createApprovedProduct();
        $incorrectSlugUrl = str_replace($product->slug, 'wrong-slug', $product->url());

        $this->get($incorrectSlugUrl)
            ->assertRedirect($product->url());
    }

    /**
     * @test
     */
    public function a_user_gets_404_when_tries_to_view_a_non_existing_product()
    {
        $this->withExceptionHandling();

        $product = $this->createApprovedProduct();
        $url = $product->url();
        $product->forceDelete();

        $this->get($url)
            ->assertStatus(404);
    }

    /**
     * @test
     */
    function a_user_gets_404_when_tries_to_view_a_non_approved_product()
    {
        $this->withExceptionHandling();

        $nonApprovedProducts = collect([
            $this->createPendingProduct(),
            $this->createRejectedProduct()
        ]);

        foreach ($nonApprovedProducts as $nonApprovedProduct) {
            $this->get($nonApprovedProduct->url())
                ->assertStatus(404);
        }
    }

    /**
     * @test
     */
    function a_user_gets_404_when_tries_to_view_an_archived_product()
    {
        $this->withExceptionHandling();

        $product = $this->createApprovedProduct();
        $product->delete();

        $this->get($product->url())
            ->assertStatus(404);
    }
}
