<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactItemController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SingleController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WordController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Utility routes
Route::get('storage_link', function () {
    return \Illuminate\Support\Facades\Artisan::call('storage:link');
});

Route::get('migrate', function () {
    return \Illuminate\Support\Facades\Artisan::call('migrate');
});

Route::get('optimize', function () {
    return \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// Admin routes
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', [PageController::class, 'login'])->name('login');
    Route::get('/register', [PageController::class, 'register'])->name('register');
    Route::post('/login_submit', [AuthController::class, 'login_submit'])->name('login_submit');
    Route::post('/register_submit', [AuthController::class, 'register_submit'])->name('register_submit');

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/home', [PageController::class, 'home'])->name('home');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        // Users & Permissions
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        // Content Management
        Route::resource('blogs', BlogController::class);
        Route::resource('blog_categories', BlogCategoryController::class);
        Route::resource('tags', TagController::class);

        // Contact & Social
        Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
        Route::resource('contact_items', ContactItemController::class);
        Route::resource('socials', SocialController::class);

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::resource('singles', SingleController::class);
        Route::resource('words', WordController::class);
        Route::resource('images', ImageController::class);
    });
});

// Front routes with localization
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    // Homepage
    Route::get('/', [FrontController::class, 'home'])->name('front.home');

    // Blog routes
    Route::get('/blog', [FrontController::class, 'blogs'])->name('front.blogs');
    Route::get('/blog/c/{categorySlug}', [FrontController::class, 'blogsByCategory'])->name('front.blogs.category');
    Route::get('/blog/t/{tagSlug}', [FrontController::class, 'blogsByTag'])->name('front.blogs.tag');
    Route::get('/blog/c/{categorySlug}/t/{tagSlug}', [FrontController::class, 'blogsByCategoryAndTag'])->name('front.blogs.category.tag');
    Route::get('/blog/{slug}', [FrontController::class, 'blogDetail'])->name('front.blog.detail');

    // Contact (commented out for now)
    // Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
    // Route::post('/contact', [FrontController::class, 'contactSubmit'])->name('front.contact.submit');
});
