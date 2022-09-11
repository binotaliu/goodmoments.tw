<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SetupPasswordController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['signed'])
    ->resource('password-setup', SetupPasswordController::class)
    ->only(['index', 'store']);

Route::redirect('/', 'admin/dashboard')->name('index');

Route::middleware('auth')->group(function (): void {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('attachments', AttachmentController::class)
        ->only(['store']);

    Route::resource('users', UserController::class)
        ->only(['index', 'store', 'edit', 'update', 'create']);

    Route::resource('categories', CategoryController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('categories.products', ProductController::class)
        ->only(['index', 'create', 'store', 'update', 'show', 'destroy'])
        ->scoped();

    Route::resource('banners', BannerController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('articles', ArticleController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});
