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
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserRatingController;

Route::resource('users', UserController::class)->only(['index', 'show']);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'search'])->name('search');

// 2FA verification routes
Route::get('/2fa/verify', [AuthController::class, 'show2faForm'])->name('2fa.verify');
Route::post('/2fa/verify', [AuthController::class, 'verify2fa'])->name('2fa.verify.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    Route::get('/user/transactions', [UserController::class, 'transactions'])->name('user.transactions');


    Route::put('/user/update', [UserController::class, 'update'])->name('user.update');

    // 2FA Routes
    Route::get('/user/2fa', [UserController::class, 'show2faSetup'])->name('user.2fa');
    Route::post('/user/2fa/enable', [UserController::class, 'enable2fa'])->name('user.2fa.enable');
    Route::post('/user/2fa/disable', [UserController::class, 'disable2fa'])->name('user.2fa.disable');

    // Routes for user addresses
    Route::resource('user/addresses', UserAddressController::class)->except(['show'])->names([
        'index' => 'user.addresses.index',
        'create' => 'user.addresses.create',
        'store' => 'user.addresses.store',
        'edit' => 'user.addresses.edit',
        'update' => 'user.addresses.update',
        'destroy' => 'user.addresses.destroy',
    ]);

    // Zarządzanie ogłoszeniami użytkownika
    Route::resource('user/listings', ListingController::class)->except(['show'])->names([
        'index' => 'user.listings.index',
        'create' => 'user.listings.create',
        'store' => 'user.listings.store',
        'edit' => 'user.listings.edit',
        'update' => 'user.listings.update',
        'destroy' => 'user.listings.destroy',
    ]);

    // Add route for user image deletion
    Route::delete('/user/listings/image/{image}', [ListingController::class, 'deleteImage'])->name('user.listings.delete-image');
    Route::post('/user/listings/image/{image}/primary', [ImageController::class, 'setPrimary'])->name('user.listings.set-primary-image');
    Route::post('/user/listings/{listing}/reorder-images', [ImageController::class, 'reorder'])->name('user.listings.reorder-images');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
    Route::get('/auth/register', 'register')->name('register');
    Route::post('/auth/register', 'store')->name('register.store');
    Route::get('/userRatings/create/{transaction_id}', [UserRatingController::class, 'create'])->name('userRatings.create');
    Route::post('/userRatings', [UserRatingController::class, 'store'])->name('userRatings.store');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');

    // Add route for admin image deletion
    Route::delete('/listings/image/{image}', [ListingController::class, 'deleteImage'])->name('listings.delete-image');
    Route::post('/listings/image/{image}/primary', [ImageController::class, 'setPrimary'])->name('listings.set-primary-image');
    Route::post('/listings/{listing}/reorder-images', [ImageController::class, 'reorder'])->name('listings.reorder-images');

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
Route::post('/transactions/{transaction}/confirm', [TransactionController::class, 'confirm'])->middleware('auth')->name('transactions.confirm');

