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
Route::group([ 'namespace' => 'Sites'], function() {
    Route::get('/', 'HomeController@home')->name('sites.home');
    Route::get('/about-us', 'HomeController@aboutUs')->name('sites.about-us');
    Route::get('search', 'ProductController@search');
    Route::get('my-cart', 'CartController@myCart')->name('sites.cart');
    Route::get('contact-us', 'HomeController@contact')->name('sites.contact');
    Route::get('size-chart', 'HomeController@sizeChart')->name('sites.size-chart');
    Route::get('my-account', 'UserController@showAccount')->name('sites.my-account');
    Route::get('order', 'OrderController@show')->name('sites.order');
    Route::get('faqs', 'HomeController@faqs')->name('sites.faqs');

    Route::resource('product', 'ProductController');
    Route::resource('users', 'UserController');
    Route::resource('categories-site', 'CategoryController');
    Route::resource('carts', 'CartController');
    Route::resource('review-product', 'ReviewController');

    Route::get('getProducts/{categoryId}/{count}', 'CategoryController@getProducts');
    Route::post('getColors', 'ProductController@getColors')->name('ajax.get-color-product');
    Route::post('getSizes', 'ProductController@getSizes')->name('ajax.get-size-product');
    Route::post('getNumber', 'ProductController@getNumber')->name('ajax.get-number-product');
    Route::post('removeProduct', 'CartController@removeProductInCart')->name('sites.cart.remove-product');
    Route::post('updateCart', 'CartController@updateCart')->name('sites.cart.update');
    Route::get('getNumberProduct/{hash}', 'CartController@getNumberProduct');
    Route::post('storeOrder', 'OrderController@store')->name('sites.order.store');

    Route::get('search', 'ProductController@search')->name('sites.search');

    Route::group(['middleware' => 'sites.login'], function () {
        Route::get('order/{order}', 'OrderController@showOrder')->name('sites.showOrder');
        Route::get('my-order', 'OrderController@getAllMyOrder')->name('sites.my-order');
        Route::resource('users', 'UserController');
    });
    Route::get('find', 'ProductController@find');
    Route::get('get-cart', 'CartController@getCart');

    Route::post('/checkCert', 'CertController@checkCert');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/', 'HomeController@index')->name('admin.index');
        Route::resource('users-admin', 'UserController');
        Route::resource('products', 'ProductController');
        Route::resource('orders', 'OrderController');
        Route::resource('reviews', 'ReViewController');
        Route::resource('categories', 'CategoryController');
        Route::resource('colors', 'ColorController');
        Route::resource('sizes', 'SizeController');

        Route::get('get-size-of-category/{categoryId}', 'SizeController@getSizeOfCategory')->name('ajax.get-size');
        Route::get('add-product/{categoryId}', 'ProductController@addProduct')->name('ajax.add-product');
        Route::get('/serverSide', 'ProductController@ajaxServerDataTable')->name('datatable.server-side');
        Route::get('/serverSide/order', 'OrderController@ajaxServerDataTable')->name('datatable.order.server-side');
    });
    Route::get('/login', 'HomeController@login');
    Route::get('/logout', 'UserController@logout')->name('admin.logout');
    Route::post('/login', 'UserController@checkLoginAdmin')->name('admin.login');
});

Auth::routes();
