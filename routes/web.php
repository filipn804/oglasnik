<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//admin
Route::prefix('admin')->middleware('auth','isAdmin')->group(function() {
    Route::get('/ads', [AdminController::class, 'adminGetAllAds'])->name('admin.ads');
    Route::get('/ads/comments', [AdminController::class, 'adminGetAllComments'])->name('admin.ads.comments');
    Route::delete('/ads/{id}', [AdminController::class, 'adminGetAllAds'])->name('admin.ads.delete');
    Route::delete('/ads/comments/{id}', [AdminController::class, 'adminGetAllAds'])->name('admin.ads.comments.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoriesController::class);
    Route::resource("/ads", App\Http\Controllers\AdsController::class);
});

require __DIR__.'/auth.php';
