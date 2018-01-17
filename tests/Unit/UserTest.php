<?php

namespace Tests\Unit;

use App\Admin;
use App\Customer;
use App\Vendor;
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
        $adminUser = factory(Admin::class)->create();
        $vendorUser = factory(Vendor::class)->create();
        $customerUser = factory(Customer::class)->create();

        $this->assertEquals(url('/admin'), $adminUser->homeUrl());
        $this->assertEquals(url('/vendor'), $vendorUser->homeUrl());
        $this->assertEquals(url('/customer'), $customerUser->homeUrl());
    }
}
