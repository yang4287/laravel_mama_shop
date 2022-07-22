<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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
//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/admin/product', function () {
    return view('admin.product');
});


// 商品CRUD
Route::prefix('product')->group(function () {
    Route::controller(ProductController::class)->group(function () {

        Route::get('/', 'index');
        Route::post('/update', 'update');
        Route::post('/add', 'add');
        Route::post('/delete', 'delete');
    });
});
