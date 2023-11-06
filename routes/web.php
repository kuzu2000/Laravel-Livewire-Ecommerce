<?php


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/collections', [App\Http\Controllers\HomeController::class, 'categories']);
Route::get('/collections/{category_slug}', [App\Http\Controllers\HomeController::class, 'products']);
Route::get('/collections/{category_slug}/{product_slug}', [App\Http\Controllers\HomeController::class, 'productView']);

Route::middleware(['auth'])->group(function() {
    Route::get('/wishlist', [App\Http\Controllers\Frontend\WishlistController::class, 'index']);
    Route::get('/cart', [App\Http\Controllers\Frontend\CartController::class, 'index']);
    Route::get('/checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index']);

    Route::get('orders', [App\Http\Controllers\Frontend\OrderController::class, 'index']);
    Route::get('orders/{orderId}', [App\Http\Controllers\Frontend\OrderController::class, 'show']);
});

Route::get('thank-you', [App\Http\Controllers\HomeController::class, 'thankYou']);

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);

    Route::controller(App\Http\Controllers\Admin\ProductController::class)->group(function() {
        Route::get('/products', 'index');
        Route::put('/products/{product}', 'update');
        Route::get('/products/create', 'create');
        Route::post('/products', 'store');
        Route::get('/products/{product}/edit', 'edit');
        Route::get('/product-image/{img_id}/delete', 'destroyImage');
    });

    Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function() {
        Route::get('/category', 'index');
        Route::put('/category/{category}', 'update');
        Route::get('/category/create', 'create');
        Route::post('/category', 'store');
        Route::get('/category/{category}/edit', 'edit');
    });
});