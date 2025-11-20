<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OderController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{category_id}', [ClientProductController::class, 'index'])->name('client.product.index');
Route::get('/product-detail/{id}', [ClientProductController::class, 'show'])->name('client.product.show');

Route::middleware('auth')->group(function () {
    Route::post('add-to-cart', [CartController::class, 'store'])->name('client.cart.add');
    Route::get('carts', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('update-quantity-product-in-cart/{cart_product_id}', [CartController::class, 'updateQuantityProduct'])->name('client.carts.update_product_quantity');
    Route::post('remove-product-in-cart/{cart_product_id}', [CartController::class, 'removeQuantityProduct'])->name('client.carts.remove_product_quantity');
    Route::post('apply-coupon', [CartController::class, 'applyCoupon'])->name('client.carts.apply_oupon');
    Route::get('checkout', [CartController::class, 'checkout'])->name('client.checkout.index')->middleware('user.can_checkout_cart');
    Route::post('process-checkout', [CartController::class, 'processCheckout'])->name('client.checkout.proccess')->middleware('user.can_checkout_cart');
    Route::get('list-orders', [OrderController::class, 'index'])->name('client.orders.index');
    Route::delete('orders/cancel/{id}', [OrderController::class, 'cancel'])->name('client.orders.cancel');
});

//LOGIN
Route::get('/login', [AuthController::class, 'index'])
    ->name('auth.login')
    ->middleware('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/register', [AuthController::class, 'signUp'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
Route::get('/verify-email/{token}', [VerifyEmailController::class, 'verify'])->name('auth.verify-email');
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('products/trashed', [ProductController::class, 'indexSoftDelete'])->name('products.trashed');
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
    Route::resource('products', ProductController::class);
    Route::resource('coupons', CouponController::class);


    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index')->middleware('list-order');
    Route::post('update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update_status')->middleware('update-order-status');
});
