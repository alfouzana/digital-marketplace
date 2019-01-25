<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Enums\UserTypes;

Route::get('/', [
    'uses' => 'HomeController@index'
]);

Route::get('/products', [
    'uses' => 'ProductsController@index'
]);

Route::get('/category/{category}', [
    'uses' => 'ProductsController@index'
]);

Route::middleware('auth')
    ->get('product/{hashid}/file', 'ProductsController@downloadFile');

Route::get('/product/{slug}/{product}', [
    'uses' => 'ProductsController@show'
]);

Route::group([
    'prefix' => '/user',
    'namespace' => 'User',
    'middleware' => ['auth', 'user'],
], function () {
    Route::get('/products', [
        'uses' => 'ProductsController@index'
    ]);

    Route::get('/purchases', 'PurchasesController@index');

    Route::group([
        'prefix' => '/new-product'
    ], function () {
        Route::get('/details', [
            'uses' => 'NewProductController@showDetailsStep'
        ]);

        Route::post('/details', [
            'uses' => 'NewProductController@processDetailsStep'
        ]);

        Route::get('/cover', [
            'uses' => 'NewProductController@showCoverStep'
        ]);

        Route::post('/cover', [
            'uses' => 'NewProductController@processCoverStep'
        ]);

        Route::get('/sample', [
            'uses' => 'NewProductController@showSampleStep'
        ]);

        Route::post('/sample', 'NewProductController@processSampleStep');

        Route::get('/product-file', 'NewProductController@showProductFileStep');
        Route::post('/product-file', 'NewProductController@processProductFileStep');

        Route::get('/confirmation', 'NewProductController@showConfirmationStep');
        Route::post('/confirmation', 'NewProductController@processConfirmationStep');

        Route::get('/download-product-file', 'NewProduct\\DownloadProductFileController@index');
    });
});

Route::group([
    'prefix' => 'customer',
    'namespace' => 'Customer',
    'middleware' => ['auth',]
], function () {
    Route::post('purchases', 'PurchasesController@store');
    
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth',]
], function () {
    Route::get('products', 'ProductsController@index');
});

Auth::routes();