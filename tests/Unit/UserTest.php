<?php

namespace Tests\Unit;

use App\Enums\UserTypes;
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
        $adminUser = create_admin_user();

        $vendorUser = create_vendor_user();

        $customerUser = create_customer_user();

        $this->assertEquals(url('/admin'), $adminUser->homeUrl());
        $this->assertEquals(url('/vendor'), $vendorUser->homeUrl());
        $this->assertEquals(url('/customer'), $customerUser->homeUrl());
    }

    /**
     * @test
     */
    public function it_can_determine_if_it_is_a_vendor()
    {
        $adminUser = create_admin_user();
        $vendorUser = create_vendor_user();
        $customerUser = create_customer_user();

        $this->assertFalse($adminUser->isVendor());
        $this->assertTrue($vendorUser->isVendor());
        $this->assertFalse($customerUser->isVendor());

    }
}
