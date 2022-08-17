<?php

use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SetupPasswordController;
use App\Http\Controllers\Admin\ProductController;
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

Route::get('/', fn () => view('welcome'));

Route::middleware(['signed'])
    ->resource('password-setup', SetupPasswordController::class)
    ->only(['index', 'store']);

Route::resource('attachments', AttachmentController::class)
    ->only(['store']);

Route::resource('users', UserController::class)
    ->only(['index', 'show', 'store', 'update', 'create']);

Route::resource('categories', CategoryController::class)
    ->only(['index', 'show', 'create', 'store', 'destroy']);

Route::resource('categories.products', ProductController::class)
    ->only(['index', 'create', 'store', 'update', 'show', 'destroy'])
    ->scoped();

Route::resource('banners', BannerController::class);
