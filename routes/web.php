<?php

use App\Http\Controllers\ShopGridController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SslCommerzPaymentController;

Route::get('/', [ShopGridController::class, 'index'])->name('home');
Route::get('/product-category/{id}', [ShopGridController::class, 'categories'])->name('product.categories');
Route::get('/product-sub-category/{id}', [ShopGridController::class, 'subCategory'])->name('product.subcategories');
Route::get('/product-detail/{id}', [ShopGridController::class, 'details'])->name('product.detail');

Route::prefix('cart')->name('cart.')->group(function () {
    // View cart
    Route::get('/', [CartController::class, 'index'])->name('index');

    // Add to cart
    Route::post('/add/{product}', [CartController::class, 'addTocart'])->name('add');

    // Update cart item
    Route::put('/update/{item}', [CartController::class, 'updateCart'])->name('update');

    // Remove from cart
    Route::get('/remove/{item}', [CartController::class, 'removeCart'])->name('remove');

    // Clear cart
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');

    // Apply coupon
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('apply-coupon');

    // Remove coupon
    Route::delete('/coupon/remove', [CartController::class, 'removeCoupon'])->name('remove-coupon');
});
Route::get('/product/checkout', [CheckoutController::class, 'index'])->name('product.checkout');
Route::post('/checkout/new-order', [CheckoutController::class, 'newOrder'])->name('checkout.new.order');
Route::get('/checkout/complete-order', [CheckoutController::class, 'completeOrder'])->name('checkout.complete.order');

Route::get('/user/login', [CustomerAuthController::class, 'login'])->name('user.login');
Route::get('/user/register', [CustomerAuthController::class, 'register'])->name('user.register');

Route::get('/', function () {
    return view('welcome');
});

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])->group(function () {
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::get('/admin/sub-categories', [SubCategoryController::class, 'index'])->name('sub-categories.index');
Route::get('/sub-categories/create', [SubCategoryController::class, 'create'])->name('sub-categories.create');
Route::post('/sub-categories/store', [SubCategoryController::class, 'store'])->name('sub-categories.store');
Route::get('/sub-categories/{id}/edit', [SubCategoryController::class, 'edit'])->name('sub-categories.edit');
Route::put('/sub-categories/{id}', [SubCategoryController::class, 'update'])->name('sub-categories.update');
Route::delete('/sub-categories/{id}', [SubCategoryController::class, 'destroy'])->name('sub-categories.destroy');

Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
Route::put('/brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/delete/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

Route::get('/admin/units', [UnitController::class, 'index'])->name('units.index');
Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
Route::post('/units/store', [UnitController::class, 'store'])->name('units.store');
Route::get('/units/edit/{id}', [UnitController::class, 'edit'])->name('units.edit');
Route::put('/units/update/{id}', [UnitController::class, 'update'])->name('units.update');
Route::delete('/units/delete/{id}', [UnitController::class, 'destroy'])->name('units.delete');

Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/detail/{id}', [ProductController::class, 'detail'])->name('admin.products.detail');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');

Route::get('/admin/customers', [CustomerController::class, 'index'])->name('customers.index');

Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index');

Route::get('/admin/create-courier', [CourierController::class, 'create'])->name('couriers.create');
Route::post('/admin/store-courier', [CourierController::class, 'store'])->name('couriers.store');
Route::put('/admin/couriers/{id}', [CourierController::class, 'edit'])->name('couriers.edit');
Route::put('/admin/couriers/update/{id}', [CourierController::class, 'update'])->name('couriers.update');
Route::delete('/admin/couriers/delete/{id}', [CourierController::class, 'destroy'])->name('couriers.delete');
Route::get('/admin/couriers', [CourierController::class, 'index'])->name('couriers.index');

Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.delete');

});
