<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AddressController as Admin_AddressController;
use App\Http\Controllers\Admin\UserController as Admin_UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;

Route::resource('users', UserController::class)->only(['index', 'show']);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('dashboards.userDashboard');
    })->name('user.dashboard');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
    Route::get('/auth/register', 'register')->name('register');
    Route::post('/auth/register', 'store')->name('register.store');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::get('/dashboard', function () {
        return view('dashboards.admindashboard');
    })->name('dashboard');
    Route::resource('users', Admin_UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('addresses', Admin_AddressController::class);
    Route::resource('listings', ListingController::class);
});


// Public routes
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
Route::post('/listings/{listing}/buy', [TransactionController::class, 'store'])->middleware('auth')->name('listings.buy');
Route::get('/payment/choose/{transaction}', [TransactionController::class, 'choosePayment'])->middleware('auth')->name('payment.choose');
Route::post('/payment/choose/{transaction}', [TransactionController::class, 'processPayment'])->middleware('auth')->name('payment.process');
Route::get('/payment/confirmation/{transaction}', [TransactionController::class, 'confirmation'])->middleware('auth')->name('payment.confirmation');

