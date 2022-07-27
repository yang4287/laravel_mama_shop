<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
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

Route::middleware(['web'])->group(function () {

    Route::controller(LoginController::class)->group(function () {

        Route::get('admin/login', 'index')->name('login');

        Route::get('admin/logout', 'logout')->name('logout');

        Route::post('auth/logincheck', 'loginCheck')->name('loginCheck');
    });

    Route::prefix('admin')->middleware('auth.login')->middleware('auth.level')->group(function () {

        Route::get('/product', function () {

            return view('admin.product');
        });
    });

    // 商品CRUD
    Route::prefix('product')->middleware('auth.login')->group(function () {
        Route::controller(ProductController::class)->group(function () {

            Route::get('/', 'index');
            // Route::get('/{id}', 'index');
            Route::middleware('auth.level')->group(function () {
                Route::post('/update', 'update');
                Route::post('/add', 'add');
                Route::post('/delete', 'delete');
            });
        });
    });
});
