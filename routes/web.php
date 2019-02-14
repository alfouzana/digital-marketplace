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

    Route::get('/products/create', 'ProductsController@create');

    Route::post('/products', 'ProductsController@store');

    Route::post('/files', 'FilesController@store');

    Route::get('/purchases', 'PurchasesController@index');
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