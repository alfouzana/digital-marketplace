<?php

namespace Tests\Unit;

use App\Enums\UserTypes;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_determine_the_home_url()
    {
        $adminUser = factory(User::class)->make([
            'type' => UserTypes::ADMIN,
        ]);

        $vendorUser = factory(User::class)->make([
            'type' => UserTypes::VENDOR,
        ]);

        $customerUser = factory(User::class)->make([
            'type' => UserTypes::CUSTOMER,
        ]);

        $this->assertEquals(url('/admin'), $adminUser->homeUrl());
        $this->assertEquals(url('/vendor'), $vendorUser->homeUrl());
        $this->assertEquals(url('/customer'), $customerUser->homeUrl());
    }
}
