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
Auth::routes();



Route::get('/', function () {
    return view('index');
});
Route::get('/backend', function () {
    return view('layouts.backend');
});


Route::get('/category', 'FrontendController@index');


Route::get('/category/{category}', 'FrontendController@category');

Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
   Route::get('/checkout', function () {
    return view('checkout');
});
});




Route::get('/cart', 'CartController@listCart');

Route::post('/masukkeranjang', 'CartController@addToCart');
Route::post('/updatekeranjang', 'CartController@updateCart');

Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    Route::get('/dashboard', function() {
        return view('admin/dashboard');
    });

    // Route::get('/user', 'UserController@index');
    // Route::post('/user-store', 'UserController@store');
    // Route::delete('/user-destroy/{id}', 'UserController@destroy');

    Route::get('/customer', 'CustomerController@index');
    Route::post('/customer-store', 'CustomerController@store');
    Route::get('/customer/{id}/edit', 'CustomerController@edit');
    Route::delete('/customer-destroy/{id}', 'CustomerController@destroy');

    Route::get('/category', 'CategoryController@index');
    Route::post('/category-store', 'CategoryController@store');
    Route::get('/category/{id}/edit', 'CategoryController@edit');
    Route::delete('/category-destroy/{id}', 'CategoryController@destroy');

    Route::get('/product', 'ProductController@index');
    Route::post('/product-store', 'ProductController@store');
    Route::get('/product/{id}/edit', 'ProductController@edit');
    Route::delete('/product-destroy/{id}', 'ProductController@destroy');

    Route::get('/stokmasuk', 'StokmasukController@index');
    Route::post('/stokmasuk-store', 'StokmasukController@store');
    Route::get('/stokmasuk/{id}/edit', 'StokmasukController@edit');
    Route::delete('/stokmasuk-destroy/{id}', 'StokmasukController@destroy');

    // Route::get('/order', 'OrderController@index');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
