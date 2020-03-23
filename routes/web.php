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

Route::get('/orders', 'Controller@orders')->name('orders');

Route::get('/suppliers', 'Controller@suppliers')->name('suppliers');

Route::get('/products', 'Controller@products')->name('products');