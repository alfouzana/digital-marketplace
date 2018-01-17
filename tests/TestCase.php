<?php

namespace Tests;

use App\User;
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

    protected function signIn(User $user = null)
    {
        $user = $user ?: factory(random_user_class())->create();

        $this->actingAs($user);

        return $user;
    }

}
