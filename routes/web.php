<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\StripeController;
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

Route::get('/', [HomeController::class, 'welcome'])->name('home');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//admin
Route::prefix('admin')->middleware(['auth'])->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoriesController::class);
    Route::resource("/ads", App\Http\Controllers\AdsController::class);
    Route::get('/ads/pay/{id}', [AdsController::class, 'pay'])->name('ads.pay');
    Route::get('/ads/invoice/{id}', [AdsController::class, 'invoice'])->name('ads.invoice');
    Route::put('/ads/pay/{id}', [AdsController::class, 'payAdAndActivate'])->name('ads.pay.and.activate');
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('/orders/invoice/{id}', [OrdersController::class, 'invoice'])->name('orders.invoice');
});

Route::middleware('auth')->group(function () {
    Route::get('cart', [AdsController::class, 'cart'])->name('cart');
    Route::get('add-to-cart/{id}', [AdsController::class, 'addToCart'])->name('add_to_cart');
    Route::patch('update-cart', [AdsController::class, 'updateCart'])->name('update_cart');
    Route::delete('remove-from-cart', [AdsController::class, 'removeFromCart'])->name('remove_from_cart');

    Route::post('/session', [StripeController::class, 'session'])->name('session');
    Route::get('/success', [StripeController::class, 'success'])->name('success');
    Route::get('/cancel', [StripeController::class, 'cancel'])->name('cancel');

    Route::post('/ad/session', [StripeController::class, 'adSession'])->name('ads.session');
    Route::get('/ad/success', [StripeController::class, 'adSuccess'])->name('ads.success');
    Route::get('/ad/cancel', [StripeController::class, 'adCancel'])->name('ads.cancel');
});

Route::get('/category/{id}', [HomeController::class, 'getAdsInCategory'])->name('ads.category');
Route::get('/ads/{id}', [HomeController::class, 'show'])->name('ads.ad');

require __DIR__.'/auth.php';
