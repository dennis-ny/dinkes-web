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
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

// public route
Route::get('/', [HomeController::class, 'index']);
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('public.article.show');

// auth route
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// public content
Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// protected route
Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');

        Route::resource('menu', MenuController::class);
        Route::resource('submenu', SubmenuController::class);
        Route::resource('slider', SliderController::class);
        Route::resource('user', UserController::class);

        // profile & account
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('account', [ProfileController::class, 'editAccount'])->name('account.edit');
        Route::put('account', [ProfileController::class, 'updateAccount'])->name('account.update');

        // pengumuman
        Route::resource('pengumuman', PengumumanController::class);
        Route::post('pengumuman/upload-image', [PengumumanController::class, 'uploadImage'])->name('pengumuman.upload_image');
        Route::post('pengumuman/upload-video', [PengumumanController::class, 'uploadVideo'])->name('pengumuman.upload_video');

        // berita
        Route::resource('berita', BeritaController::class);
        Route::post('berita/upload-image', [BeritaController::class, 'uploadImage'])->name('berita.upload_image');
        Route::post('berita/upload-video', [BeritaController::class, 'uploadVideo'])->name('berita.upload_video');

        // article & category
        Route::resource('article', ArticleController::class);
        Route::post('article/upload-image', [ArticleController::class, 'uploadImage'])->name('article.uploadImage');
        Route::resource('category', CategoryController::class);
    });

    Route::middleware(['role:upt'])->prefix('upt')->name('upt.')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');
    });
});
