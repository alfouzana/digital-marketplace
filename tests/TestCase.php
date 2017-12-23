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

    protected function tearDown()
    {
        $this->clearProductCoversDir();
        $this->clearProductSamplesDir();
        $this->clearProductFilesDir();

        parent::tearDown();
    }

    protected function clearProductCoversDir()
    {
        $this->clearDirectory(product_covers_path());
    }

    protected function clearProductSamplesDir()
    {
        $this->clearDirectory(product_samples_path());
    }

    protected function clearProductFilesDir()
    {
        $this->clearDirectory(product_files_path());
    }

    protected function clearDirectory($dir)
    {
        $files = $this->app['files']->files($dir);

        $paths = array_map(function (SplFileInfo $file) {
            return $file->getRealPath();
        }, $files);

        $this->app['files']->delete($paths);
    }
}
