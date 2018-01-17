<?php

namespace Tests\Unit;

use App\Admin;
use App\Customer;
use App\Enums\UserTypes;
use App\User;
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

    /**
     * @test
     */
    public function it_can_determine_if_it_is_a_vendor()
    {
        $adminUser = factory(Admin::class)->create();
        $vendorUser = factory(Vendor::class)->create();
        $customerUser = factory(Customer::class)->create();

        $this->assertFalse($adminUser->isVendor());
        $this->assertTrue($vendorUser->isVendor());
        $this->assertFalse($customerUser->isVendor());

    }
}
