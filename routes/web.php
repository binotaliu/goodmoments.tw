<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProductController;
use App\Http\Requests\IndexController;
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

Route::get('/', IndexController::class)->name('index');

Route::get('products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('categories/{category:slug}/products', [ProductController::class, 'index'])
    ->name('categories.products.index');

Route::get('categories/{category:slug}/products/{product:slug}', [ProductController::class, 'show'])
    ->name('categories.products.show')
    ->scopeBindings();

Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('about', AboutController::class)->name('about');

Route::feeds();
