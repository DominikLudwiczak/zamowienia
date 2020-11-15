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

Route::get('/dashboard', function() {
    return view('dashboard');
})->middleware('CheckActive')->name('dashboard');


Auth::routes(['register' => false, 'reset' => false, 'confirm' => false]);

//Password reset
Route::prefix('password/reset')->group(function(){
    Route::get('/', function() {
        return view('auth.passwords.reset');
    })->name('password.change');

    Route::post('/', '\App\Http\Controllers\Auth\ResetPasswordController@change')->middleware('CheckPasswordChange')->name('password.changing');
});

//Suppliers
Route::prefix('suppliers')->group(function() {

    Route::get('/', 'SuppliersController@suppliers')->name('suppliers');

    Route::get('/search', 'SuppliersController@search')->name('suppliers_search');

    Route::get('/new', function() {
        return view('suppliers.new_supplier');
    })->middleware('CheckActive')->middleware('CheckAdmin')->name('new_supplier');

    Route::post('/new', 'SuppliersController@add_supplier')->middleware('CheckSupplier')->name('add_supplier');

    Route::get('/edit/{id}', 'SuppliersController@edit')->where(['id' => '[0-9]+'])->name('edit_supplier');

    Route::post('/edit/{id}', 'SuppliersController@edit_save')->where(['id' => '[0-9]+'])->middleware('CheckSupplier')->name('edit_supplier_save');

    Route::post('/delete', 'SuppliersController@delete')->name('delete_supplier');
});

//Products
Route::prefix('products')->group(function() {
    
    Route::get('/', 'ProductsController@products')->name('products');

    Route::get('/search', 'ProductsController@search')->name('products_search');

    Route::get('/new', 'ProductsController@new_product')->name('new_product');

    Route::post('/new', 'ProductsController@add_product')->middleware('CheckProduct')->name('add_product');

    Route::get('/edit/{id}', 'ProductsController@edit')->where(['id' => '[0-9]+'])->name('edit_product');

    Route::post('/edit/{id}', 'ProductsController@edit_product_save')->where(['id' => '[0-9]+'])->middleware('CheckProduct')->name('edit_product_save');

    Route::post('/delete', 'ProductsController@delete')->name('delete_product');
});

//Orders
Route::prefix('orders')->group(function() {
    Route::get('/', 'OrdersController@orders')->name('orders');

    Route::get('/search', 'OrdersController@search')->name('orders_search');

    Route::get('/details/{order_id}', 'OrdersController@order_details')->where(['order_id' => '[0-9]+'])->name('order_details');

    Route::get('/new/{supplier_name?}', 'OrdersController@new_order')->name('new_order');

    Route::get('/setAmmount', 'OrdersController@setAmmount')->name('setAmmount');
    
    Route::post('/confirm', 'OrdersController@confirm')->name('new_order_confirm');

    Route::get('/confirm/search', 'OrdersController@confirm_search')->name('confirm_search');

    Route::get('/search_prod', 'OrdersController@search_prod')->name('orders_search_prod');
    
    Route::post('/send', 'OrdersController@send')->name('new_order_send');
});

// Calendar
Route::prefix('calendar')->group(function() {

    // Vacations
    Route::prefix('vacations')->group(function() {
        Route::get('/{month?}/{year?}', 'CalendarController@calendar')->where(['month' => '[0-9]+', 'year' => '[0-9]+'])->name('vacations');

        Route::get('/add', 'CalendarController@add')->name('vacation_add');
        Route::post('/add', 'CalendarController@add_store')->middleware('CheckVacation');

        Route::get('/requests', 'CalendarController@requests')->name('requests');
        Route::get('/search', 'CalendarController@request_search')->name('requests_search');

        Route::get('/request/{id}', 'CalendarController@request')->where(['id' => '[0-9]+'])->name('request');
        Route::post('/request/{id}', 'CalendarController@request_store')->where(['id' => '[0-9]+']);
    });

    // Scheduler
    Route::prefix('scheduler')->group(function() {

        // user
        Route::get('/user/{month?}/{year?}', 'SchedulerController@scheduler_user')->where(['month' => '[0-9]+', 'year' => '[0-9]+'])->name('scheduler_user');

        //admin
        Route::get('/admin', 'SchedulerController@scheduler_admin')->middleware('CheckAdmin')->name('scheduler_admin');

        // all
        Route::get('/view/{id}', 'SchedulerController@view')->where(['id' => '[0-9]+'])->name('scheduler_view');

        // shop-(admin)
        Route::prefix('shop')->middleware('CheckAdmin')->group(function() {
            Route::get('/{id}/{month?}/{year?}', 'SchedulerController@scheduler_shop')->where(['id' => '[0-9]+', 'month' => '[0-9]+', 'year' => '[0-9]+'])->name('scheduler_shop');

            Route::get('/add/{id}', 'SchedulerController@add')->where(['id' => '[0-9]+'])->name('scheduler_add');
            Route::post('/add/{id}', 'SchedulerController@add_store')->where(['id' => '[0-9]+'])->middleware('CheckScheduler');

            Route::get('/edit/{id}', 'SchedulerController@edit')->where(['id' => '[0-9]+'])->name('scheduler_edit');
            Route::post('/edit/{id}', 'SchedulerController@edit_store')->where(['id' => '[0-9]+'])->middleware('CheckScheduler');

            Route::post('/delete', 'SchedulerController@delete')->name('scheduler_delete');
        });
    });
});

// Shops
Route::prefix('shops')->group(function() {
    Route::get('/', 'ShopsController@shops')->name('shops');

    Route::get('/search', 'ShopsController@search')->name('shops_search');

    Route::get('/edit/{id}', 'ShopsController@edit')->where(['id' => '[0-9]+'])->name('edit_shop');
    Route::post('/edit/{id}', 'ShopsController@edit_store')->where(['id' => '[0-9]+'])->middleware('CheckShop');

    Route::post('/delete', 'ShopsController@delete')->name('delete_shop');

    Route::get('/add', function(){
        return view('shops.add');
    })->name('add_shop');

    Route::post('/add', 'ShopsController@add_store')->middleware('CheckShop');
});