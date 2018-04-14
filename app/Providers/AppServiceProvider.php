<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

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

        $this->app['view']->composer('vendor.new-product.details-step', function ($view) {
           $categories = Category::all();

           $category_options = ['' => __('Please select one ...')] +
               $categories->pluck('id')->combine($categories->pluck('name'))->all();

            $view['category_options'] = $category_options;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
