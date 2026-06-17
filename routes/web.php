<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index1'])->name('home');

Route::get('/list', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/signup', [ClientController::class, 'signup1'])->name('signup');
Route::post('/signup', [ClientController::class, 'signup'])->name('signup.send');


Route::get('/login', [ClientController::class, 'login1'])->name('login');
Route::post('/login', [ClientController::class, 'login'])->name('login1');

Route::middleware(['auth'])->group(function () {
    Route::get('/profiles', [ClientController::class, 'profile1'])->name('profile1');

    Route::get('/logout', [ClientController::class, 'logout'])->name('logout');

//    Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
//    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
//    Route::get('/products-panel', [ProductController::class, 'indexPanel'])->name('products.panel');
//
//    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
//    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
//    Route::get('/product/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::get('/info', [ProductController::class, 'info'])->name('info');
Route::get('/contacts', [ProductController::class, 'contacts'])->name('contacts');
Route::get('/employees', [ProductController::class, 'employees'])->name('employees');

//Route::middleware(['auth'])->group(function () {
//    Route::get('/admin', [ProductController::class, 'admin'])->name('admin');
//
//    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
//    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
//    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
//
//    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
//    Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
//    Route::get('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
//    Route::patch('/order/update/{order}', [OrderController::class, 'updateStatus'])->name('order.update');
//
//    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
//
//    Route::get('/admin/employees', [AdminController::class, 'employees'])->name('admin.employees');
//    Route::get('/admin/employees/create', [AdminController::class, 'createEmployee'])->name('admin.employees.create');
//    Route::post('/admin/employees/store', [AdminController::class, 'storeEmployee'])->name('admin.store');
//    Route::get('/admin/employees/delete/{id}', [AdminController::class, 'deleteEmployee'])->name('admin.employees.delete');
//
//});

Route::middleware(['auth:client'])->group(function () {
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::get('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    Route::get('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::get('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');

    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');
    Route::get('/profile/orders', [ClientController::class, 'orderList'])->name('profile.orders');
    Route::get('/profile/order/{id}', [ClientController::class, 'showOrder'])->name('profile.order.show');

    Route::get('/profile', [ClientController::class, 'profile'])->name('profile');

    Route::get('/profile/order/{id}/print', [OrderController::class, 'print'])->name('profile.order.print');
    Route::get('/profile/order/{id}/download', [OrderController::class, 'download'])->name('profile.order.download');
});

// === МАРШРУТЫ ДОСТАВКИ ===
Route::middleware(['auth:client'])->group(function () {
    Route::get('/profile/order/{order}/delivery/create', [App\Http\Controllers\DeliveryController::class, 'create'])->name('delivery.create');
    Route::post('/profile/order/{order}/delivery', [App\Http\Controllers\DeliveryController::class, 'store'])->name('delivery.store');
    Route::get('/profile/order/{order}/delivery', [App\Http\Controllers\DeliveryController::class, 'show'])->name('delivery.show');
    Route::get('/profile/order/{order}/delivery/edit', [App\Http\Controllers\DeliveryController::class, 'edit'])->name('delivery.edit');
    Route::put('/profile/order/{order}/delivery', [App\Http\Controllers\DeliveryController::class, 'update'])->name('delivery.update');
});

// Для администратора и менеджера
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::patch('/admin/delivery/{delivery}/status', [App\Http\Controllers\DeliveryController::class, 'updateStatus'])->name('admin.delivery.updateStatus');
});
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::patch('/staff/delivery/{delivery}/status', [App\Http\Controllers\DeliveryController::class, 'updateStatus'])->name('staff.delivery.updateStatus');
});

//Route::prefix('staff')->name('staff.')->group(function () {
//    Route::get('/login', [UserController::class, 'login1'])->name('login');
//    Route::post('/login', [UserController::class, 'login'])->name('login.submit');
//    Route::get('/signup', [UserController::class, 'signup1'])->name('signup');
//    Route::post('/signup', [UserController::class, 'signup'])->name('signup.submit');
//});
//
//Route::middleware('auth')->prefix('staff')->name('staff.')->group(function () {
//    Route::get('/panel', [UserController::class, 'index'])->name('panel');
//    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
//});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/logout', [UserController::class, 'logout'])->name('admin.logout');

    // Продукты
    Route::get('/admin/panel', [UserController::class, 'index'])->name('admin.panel');

    Route::get('/products-panel', [ProductController::class, 'indexPanel'])->name('products.panel');
    Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/product/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Категории
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Сотрудники
    Route::get('/admin/employees', [AdminController::class, 'employees'])->name('admin.employees');
    Route::get('/admin/employees/create', [AdminController::class, 'createEmployee'])->name('admin.employees.create');
    Route::post('/admin/employees/store', [AdminController::class, 'storeEmployee'])->name('admin.store');
    Route::get('/admin/employees/delete/{id}', [AdminController::class, 'deleteEmployee'])->name('admin.employees.delete');

    // Заказы
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('order.index');
    Route::patch('/admin/order/update/{order}', [OrderController::class, 'updateStatus'])->name('admin.order.update');
});

Route::get('/staff/login', [UserController::class, 'login1'])->name('staff.login');
Route::post('/staff/login', [UserController::class, 'login'])->name('staff.login.submit');
Route::get('/staff/signup', [UserController::class, 'signup1'])->name('staff.signup');
Route::post('/staff/signup', [UserController::class, 'signup'])->name('staff.signup.submit');

Route::middleware(['auth', 'role:manager'])->group(function () {
    // Заказы
    Route::get('/staff/logout', [UserController::class, 'logout'])->name('staff.logout');

    Route::get('/staff/panel', [UserController::class, 'index'])->name('staff.panel');
    Route::get('/orders', [OrderController::class, 'index'])->name('staff.order.index');
    Route::patch('/order/update/{order}', [OrderController::class, 'updateStatusStaff'])->name('staff.order.update');
});
