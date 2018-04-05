<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_visit_the_home_page()
    {
        $product = create_approved_product();
        create_product_files($product->id);

        $this->get('/')
            ->assertStatus(200);
    }
}
