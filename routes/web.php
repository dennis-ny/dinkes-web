<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\PengumumanController;

// public route
Route::get('/', [HomeController::class, 'index']);

// auth route
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// public
Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');


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

        // slider
        Route::resource('slider', SliderController::class)->names('slider');
        // user
        Route::resource('user', UserController::class)->names('user');

        // profile
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        // pengumuman
        Route::resource('pengumuman', PengumumanController::class)->names('pengumuman');
        Route::post('pengumuman/upload-image', [PengumumanController::class, 'uploadImage'])->name('pengumuman.upload_image');
        Route::post('/pengumuman/upload-video', [PengumumanController::class, 'uploadVideo'])->name('pengumuman.upload_video');

        // berita
        Route::resource('berita', BeritaController::class)->names('berita');
        Route::post('berita/upload-image', [BeritaController::class, 'uploadImage'])->name('berita.upload_image');
        Route::post('/berita/upload-video', [BeritaController::class, 'uploadVideo'])->name('berita.upload_video');
    });

    // upt route
    Route::middleware(['role:upt'])->prefix('upt')->name('upt.')->group(function () {
        // dashboard
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');
    });
});
