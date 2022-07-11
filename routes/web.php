<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
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
    return view('welcome');
});
Route::get('/test', function () {
    return view('test');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/admin/product', function () {
    return view('admin.product');
});

Route::get('/product_info',[adminController::class, 'all_info_product']);
Route::post('/update_product_save',[adminController::class, 'update_commodity_save']);
Route::post('/add_product_save',[adminController::class, 'add_commodity_save']);
Route::post('/delete_product',[adminController::class, 'delete_commodity']);