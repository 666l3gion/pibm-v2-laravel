<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('/')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        // Route::middleware(['role:superadmin,admin,editor'])->group(function () {
        //     Route::resource('/articles', ArticleController::class)->except(['index', 'show']);
        // });
        // Route::middleware(['role:superadmin,admin'])->group(function () {
        // });
        // Route::middleware('role:superadmin')->group(function () {
        // });
    });
    Route::prefix('/master')->name('master.')->group(function () {
        Route::resource('/teachers', TeacherController::class)->except('show');
        Route::resource('/majors', MajorController::class)->except('show');
        Route::resource('/classes', ClassController::class)->except('show');
    });

    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});
