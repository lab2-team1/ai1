<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/userdashboard', function () {
    return view('dashboards.userDashboard');
})->name('userDashboard');

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
});
