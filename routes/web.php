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

Route::get('/suppliers', 'Controller@suppliers')->name('suppliers');
    
Route::get('/products', 'Controller@products')->name('products');

Route::prefix('orders')->group(function(){
    Route::get('/', 'OrdersController@orders')->name('orders');

    Route::get('/new', 'OrdersController@new_order_suppliers')->name('new_order');
    
    Route::post('/news', 'OrdersController@new_order_choosen')->name('new_order_choosen');
    
    Route::post('/confirm', 'OrdersController@confirm')->name('new_order_confirm');
    
    Route::post('/send', 'OrdersController@send')->name('new_order_send');
});