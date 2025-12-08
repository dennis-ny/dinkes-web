<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubmenuController;

// public route
Route::get('/', function () {
    return view('public.home');
});

// auth route
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// protected route
Route::middleware(['auth'])->group(function () {
    // admin route
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // dashboard
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        // menu
        Route::resource('menu', MenuController::class)->names('menu');

        // submenu
        Route::resource('submenu', SubmenuController::class)->names('submenu');
    });

    // upt route
    Route::middleware(['role:upt'])->prefix('upt')->name('upt.')->group(function () {
        // dashboard
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');
    });
});