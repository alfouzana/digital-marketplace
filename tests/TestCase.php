<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Product;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $resourceDirectories = [
        'product_covers',
        'product_samples',
        'product_files',
    ];

    protected function  setUp()
    {
        parent::setUp();

        $this->registerResourceDirectories();

        $this->createResourceDirectories();

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

    protected function tearDown()
    {
        $this->deleteResourceDirectories();

        parent::tearDown();
    }

    protected function registerResourceDirectories()
    {
        foreach ($this->resourceDirectories as $directory) {
            $this->app->instance("{$directory}_dir", "tests_{$directory}");
        }
    }

    protected function createResourceDirectories()
    {
        foreach ($this->resourceDirectories as $directory) {
            $directoryPath = ($directory.'_path')();

            if ($this->app['files']->isDirectory($directoryPath)) {
                $this->app['files']->deleteDirectory($directoryPath);
            }

            $this->app['files']->makeDirectory($directoryPath, 0755, true);
        }
    }

    protected function deleteResourceDirectories()
    {
        foreach ($this->resourceDirectories as $directory) {
            $this->app['files']->deleteDirectory(($directory.'_path')());
        }
    }

}
