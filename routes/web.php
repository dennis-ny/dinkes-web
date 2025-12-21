<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GuestArticleController;
use App\Http\Controllers\DashboardController;

// public route
Route::get('/', [HomeController::class, 'index']);
Route::get('/artikel', [App\Http\Controllers\ArticleController::class, 'publicIndex'])->name('public.article.index');
Route::get('/artikel/kategori/{category:slug}', [App\Http\Controllers\ArticleController::class, 'publicIndex'])->name('public.article.category');
Route::get('/artikel/author/{author}', [App\Http\Controllers\ArticleController::class, 'publicIndex'])->name('public.article.author');
Route::get('/artikel/{article:slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('public.article.show');

Route::get('/berita', [NewsController::class, 'publicIndex'])->name('public.news.index');
Route::get('/berita/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/pengumuman', [AnnouncementController::class, 'publicIndex'])->name('public.announcement.index');
Route::get('/pengumuman/{announcement:slug}', [AnnouncementController::class, 'show'])->name('announcement.show');

Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show');

// guest article submission
Route::middleware(['throttle:6,60'])->group(function () {
    Route::get('/ajukan-artikel', [GuestArticleController::class, 'create'])->name('public.article.create');
    Route::post('/ajukan-artikel', [GuestArticleController::class, 'store'])->name('public.article.store');
    Route::post('/guest/article/upload-image', [GuestArticleController::class, 'uploadImage'])->name('public.article.uploadImage');
    Route::post('/guest/article/delete-image', [GuestArticleController::class, 'deleteImage'])->name('public.article.deleteImage');
});

// auth route
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// protected route
Route::middleware(['auth'])->group(function () {
    // shared routes for admin and upt
    Route::middleware(['role:admin,upt'])->prefix('dashboard')->group(function () {
        // article
        Route::resource('article', App\Http\Controllers\ArticleController::class)->names('admin.article');
        Route::post('article/upload-image', [App\Http\Controllers\ArticleController::class, 'uploadImage'])->name('admin.article.uploadImage');
        Route::post('article/delete-image', [App\Http\Controllers\ArticleController::class, 'deleteImage'])->name('admin.article.deleteImage');

        // news
        Route::resource('news', NewsController::class)->except(['show'])->names('admin.news');
        Route::post('news/upload-image', [NewsController::class, 'uploadImage'])->name('admin.news.uploadImage');
        Route::post('news/delete-image', [NewsController::class, 'deleteImage'])->name('admin.news.deleteImage');
        Route::post('news/upload-video', [NewsController::class, 'uploadVideo'])->name('admin.news.uploadVideo');

        // announcement
        Route::resource('announcement', AnnouncementController::class)->except(['show'])->names('admin.announcement');
        Route::post('announcement/upload-image', [AnnouncementController::class, 'uploadImage'])->name('admin.announcement.uploadImage');
        Route::post('announcement/delete-image', [AnnouncementController::class, 'deleteImage'])->name('admin.announcement.deleteImage');
    });

    // admin only route
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

        // account settings
        Route::get('account', [ProfileController::class, 'editAccount'])->name('account.edit');
        Route::put('account', [ProfileController::class, 'updateAccount'])->name('account.update');

        // article submissions
        Route::get('article/submissions', [App\Http\Controllers\ArticleController::class, 'submissions'])->name('article.submissions');
        Route::post('article/{article}/approve', [App\Http\Controllers\ArticleController::class, 'approve'])->name('article.approve');
        Route::post('article/{article}/reject', [App\Http\Controllers\ArticleController::class, 'reject'])->name('article.reject');

        // page
        Route::resource('page', PageController::class)->except(['show'])->names('page');
        Route::post('page/upload-image', [PageController::class, 'uploadImage'])->name('page.uploadImage');
        Route::post('page/delete-image', [PageController::class, 'deleteImage'])->name('page.deleteImage');

        // category
        Route::resource('category', App\Http\Controllers\CategoryController::class)->names('category');
    });

    // upt only route
    Route::middleware(['role:upt'])->prefix('upt')->name('upt.')->group(function () {
        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});
