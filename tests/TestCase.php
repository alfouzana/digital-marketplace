<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Product;
use Symfony\Component\Finder\SplFileInfo;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    protected function createApprovedProduct()
    {
        $product = $this->createProduct();

        $product->approve();

        return $product;
    }

    protected function createRejectedProduct()
    {
        $product = $this->createProduct();

        $product->reject();

        return $product;
    }

    protected function createPendingProduct()
    {
        return $this->createProduct();
    }

    protected function createProduct()
    {
        return factory(Product::class)->create();
    }
}
