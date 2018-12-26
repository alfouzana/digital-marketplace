<?php

namespace Tests;

use App\Admin;
use App\Customer;
use App\User;
use App\Vendor;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Product;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function  setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    protected function signIn(User $user = null)
    {
        $user = $user ?: factory(random_user_class())->create();

        $this->actingAs($user);

        return $user;
    }

    protected function createNonVendorUser()
    {
        return mt_rand(1, 100) <= 50 ?
            factory(Admin::class)->create():
            factory(Customer::class)->create();
    }

    protected function createNonAdminUser()
    {
        return mt_rand(1, 100) <= 50 ?
            factory(Vendor::class)->create():
            factory(Customer::class)->create();
    }

    protected function createNonCustomerUser()
    {
        return mt_rand(1, 100) <= 50 ?
            factory(Admin::class)->create():
            factory(Vendor::class)->create();
    }
}
