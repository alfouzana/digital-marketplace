<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_determine_the_home_url()
    {
        $user = factory(User::class)->make();
        $admin = factory(User::class)->states('admin')->make();

        $this->assertEquals(url('/user'), $user->homeUrl());
        $this->assertEquals(url('/admin'), $admin->homeUrl());
    }
}
