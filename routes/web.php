<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\OrderController;
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
    return view('home');
});

Route::middleware(['web'])->group(function () {

    Route::controller(LoginController::class)->group(function () {

        Route::get('/admin/login', 'index')->name('login');

        Route::get('/admin/logout', 'logout')->name('logout');

        Route::post('/auth/logincheck', 'loginCheck')->name('loginCheck');
    });

    Route::prefix('/admin')->middleware(['auth.login', 'auth.level'])->group(function () {

        Route::get('/product', function () {

            return view('admin.product');
        });
        Route::controller(ProductController::class)->group(function () {

            Route::get('/product/list', 'index'); //所有商品資訊包含下架的
            Route::post('/product/update', 'update');
            Route::post('/product/add', 'add');
            Route::post('/product/delete', 'delete');
        });
    });
    Route::prefix('/member')->middleware(['auth.login'])->group(function () {


        Route::controller(CartController::class)->group(function () {

            Route::get('/api/cart/list', 'index'); 
            Route::post('/api/cart/add', 'add'); 
            Route::patch('/api/cart/update', 'update'); 
            Route::delete('/api/cart/delete', 'delete'); 
            Route::get('/cart', function () {

                return view('member.cart');
            });


        });
    });
    Route::prefix('/member')->group(function () {


        Route::controller(CartController::class)->group(function () {

            Route::get('/cart/sum', 'amountSum');
        });
    });
    Route::controller(LoginController::class)->group(function () {

        Route::get('/member/login', 'member_index')->name('member_index');

        Route::get('/member/logout', 'logout')->name('member_logout');

        Route::post('/member/auth/login', 'memberLoginCheck')->name('memberLoginCheck');
    });



    Route::controller(SmsController::class)->group(function () {
        Route::post('/api/sendSms', 'index')->name('sendSms');
        Route::post('/auth/verifySms', 'verify')->name('verifySms');
    });

    Route::get('/member/register/step1', function () {
        return view('member.account.register.smsVerify');
    });

    Route::middleware('verified.phone')->group(function () {
        Route::get('/member/register/step2', function () {
            return view('member.account.register.information');
        });
        Route::controller(AccountController::class)->group(function () {
            Route::post('/member/auth/register', 'register')->name('register');
        });
    });


    // 商品CRUD
    Route::prefix('/product')->group(function () {
        Route::controller(ProductController::class)->group(function () {



            //商店顯示的商品

            Route::get('/{product_id}', 'shop_index')->whereNumber('product_id');
            Route::get('/{class}', 'shop_index');
        });
    });
});
Route::controller(CartController::class)->group(function () {

    Route::get('/cart/checkAll', 'checkAll');
});
Route::controller(OrderController::class)->group(function () {

    Route::post('/order', 'index');
    Route::post('/order/checkCallback', 'checkCallback');
});