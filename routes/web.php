<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Auth::routes();

Route::get('/dashboard', function()
{
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/suppliers', 'SuppliersController@suppliers')->name('suppliers');

Route::prefix('products')->group(function(){
    
    Route::get('/', 'ProductsController@products')->name('products');

    Route::get('/new', 'ProductsController@new_product')->name('new_product');

    Route::post('/new', 'ProductsController@add_product')->middleware('CheckProduct')->name('add_product');
});

Route::prefix('orders')->group(function(){
    Route::get('/', 'OrdersController@orders')->name('orders');

    Route::get('/details/{order_id}', 'OrdersController@order_details')->name('order_details');

    Route::get('/new/{supplier_name?}', 'OrdersController@new_order')->name('new_order');
    
    Route::post('/confirm', 'OrdersController@confirm')->name('new_order_confirm');
    
    Route::post('/send', 'OrdersController@send')->name('new_order_send');
});