<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListingController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/userdashboard', function () {
    return view('dashboards.userDashboard');
})->name('userDashboard');

Route::get('/admindashboard', function () {
    return view('dashboards.adminDashboard');
})->name('adminDashboard');


Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
});

Route::resource('categories', CategoryController::class);
Route::resource('listings', ListingController::class);
