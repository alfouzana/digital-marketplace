<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require_once base_path('lib'.DIRECTORY_SEPARATOR.'helpers.php');
        require_once base_path('lib'.DIRECTORY_SEPARATOR.'view-helpers.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResourceDirectories();
    }

    protected function registerResourceDirectories()
    {
        $this->app->instance('product_covers_dir', 'product_covers');
        $this->app->instance('product_samples_dir', 'product_samples');
        $this->app->instance('product_files_dir', 'product_files');
    }
}
