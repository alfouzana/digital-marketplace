<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_admin_can_get_the_data_of_a_product()
    {
        $admin = factory(User::class)->states('admin')->create();
        $product = factory(Product::class)->create();

        $this->actingAs($admin);

        $this->get('admin/product/'.$product->id)
        	->assertJson($product->toArray());
    }
}