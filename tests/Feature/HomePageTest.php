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
        $this->get('/')
            ->assertStatus(200);
    }
}
