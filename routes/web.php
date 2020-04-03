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

//Suppliers
Route::prefix('suppliers')->group(function(){

    Route::get('/', 'SuppliersController@suppliers')->name('suppliers');

    Route::get('/new', function(){
        return view('suppliers.new_supplier');
    })->middleware('auth')->name('new_supplier');

    Route::post('/new', 'SuppliersController@add_supplier')->middleware('CheckSupplier')->name('add_supplier');

    Route::get('/edit/{id}', 'SuppliersController@edit')->name('edit_supplier');

    Route::post('/edit/{id}', 'SuppliersController@edit_save')->middleware('CheckSupplier')->name('edit_supplier_save');

    Route::post('/delete', 'SuppliersController@delete')->name('delete_supplier');
});

//Products
Route::prefix('products')->group(function(){
    
    Route::get('/', 'ProductsController@products')->name('products');

    Route::get('/new', 'ProductsController@new_product')->name('new_product');

    Route::post('/new', 'ProductsController@add_product')->middleware('CheckProduct')->name('add_product');

    Route::get('/edit/{id}', 'ProductsController@edit')->name('edit_product');

    Route::post('/edit/{id}', 'ProductsController@edit_product_save')->middleware('CheckProduct')->name('edit_product_save');

    Route::post('/delete', 'ProductsController@delete')->name('delete_product');
});

//Orders
Route::prefix('orders')->group(function(){
    Route::get('/', 'OrdersController@orders')->name('orders');

    Route::get('/details/{order_id}', 'OrdersController@order_details')->name('order_details');

    Route::get('/new/{supplier_name?}', 'OrdersController@new_order')->name('new_order');
    
    Route::post('/confirm', 'OrdersController@confirm')->name('new_order_confirm');
    
    Route::post('/send', 'OrdersController@send')->name('new_order_send');
});