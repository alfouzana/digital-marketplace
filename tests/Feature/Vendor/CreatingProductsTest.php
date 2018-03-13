<?php

namespace Tests\Feature\Vendor;

use App\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatingProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_non_vendor_user_may_not_create_a_product()
    {
        $this->withExceptionHandling();

        // unauthenticated attempt
        $this->get('/vendor/products/create')
            ->assertRedirect('/login');
        $this->post('/vendor/products')
            ->assertRedirect('/login');

        // non vendor user
        $this->actingAs(
            $this->createNonVendorUser()
        );
        $this->get('/vendor/products/create')
            ->assertStatus(403);
        $this->post('/vendor/products')
            ->assertStatus(403);
    }
}
